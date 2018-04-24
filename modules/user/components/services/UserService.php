<?php

namespace app\modules\user\components\services;

use app\components\EmailSender;
use app\components\helpers\DateHelper;
use app\modules\user\components\repository\UserRepository;
use app\modules\user\models\User;
use app\modules\user\models\UserProfile;
use nodge\eauth\ErrorException;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Class UserService
 * @package app\modules\user\components\services
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EmailSender
     */
    private $emailSender;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param EmailSender $emailSender
     */
    public function __construct (UserRepository $userRepository, EmailSender $emailSender)
    {
        $this->userRepository = $userRepository;
        $this->emailSender = $emailSender;
    }

    /**
     * @param $data
     * @return bool
     * @throws Exception
     */
    public function updateProfile ($data)
    {
        $userId = \Yii::$app->user->id;

        if (!$userId) {
            throw new Exception('User not found!');
        }

        $user = $this->userRepository->findById($userId);
        $profile = $this->userRepository->getProfile($userId);

        $user->attributes = $data;
        $this->userRepository->saveUser($user);

        $profile->attributes = $data;
        $profile->birth_date = DateHelper::convertDate($data['birth_date'], 'yyyy-MM-dd');
        $this->userRepository->saveProfile($profile);

        return true;
    }

    /**
     * @param $idUser
     */
    public function addProfile ($idUser)
    {
        $model = new UserProfile;
        $model->user_id = $idUser;

        $this->userRepository->saveProfile($model);
    }

    /**
     * @param $idUser
     * @param $path
     * @return bool
     */
    public function setAvatar ($idUser, $path)
    {
        $this->userRepository->updateAvatar($idUser, $path);

        return true;
    }

    /**
     * @param $role
     * @return array|\app\modules\user\models\User[]
     */
    public function getUsersByRole ($role)
    {
        return $this->userRepository->findUsersByRole($role);
    }

    /**
     * @param $userId
     * @throws NotFoundHttpException
     */
    public function guardIsExists ($userId)
    {
        if (!$this->userRepository->findById($userId)) {
            throw new NotFoundHttpException('User not found');
        }
    }

    public function signup ($data)
    {
        $user = new User;
        $user->attributes = $data;
        $user->setPassword($data['password']);
        $user->generateAuthKey();
        $user->is_really_password = 1;

        $user = $this->userRepository->saveUser($user);

        $profile = $this->userRepository->getProfile($user->id);

        $profile->attributes = $data;
        $profile->birth_date = $data['year'] . '-' . $data['month'] . '-' . $data['date'];
        $profile->gender = intval($data['gender']) == 1 ? 'male' : 'female';
        $this->userRepository->saveProfile($profile);

        Yii::$app->getUser()->login($user);
        $this->emailConfirmationRequest($user->id);
    }

    protected function emailConfirmationRequest ($userId)
    {
        /* @var $user User */
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            return false;
        }

        if (!$this->isEmailConfirmationTokenValid($user->email_confirmation_token)) {
            $this->generateEmailConfirmationToken($user);
            $user = $this->userRepository->findById($userId);
        }

        $data['subject'] = 'Подтверждение адреса электронной почты ' . Yii::$app->name;
        $data['text'] = "<p>Для подтверждения перейдите по ссылке: </p><br><br>";
        $data['text'] .= Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm/', 'token' => $user->email_confirmation_token]);

        $this->emailSender->sendMail($data, 'user/emailConfirmation', [$user->email]);
    }

    /**
     * Finds out if email confirmation token is valid
     *
     * @param string $token
     * @return bool
     */
    private function isEmailConfirmationTokenValid ($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.emailConfirmationTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * Generates email confirmation token
     *
     * @param $user User
     */
    private function generateEmailConfirmationToken ($user)
    {
        $user->email_confirmation_token = Yii::$app->security->generateRandomString() . '_' . time();
        $this->userRepository->saveUser($user);
    }

    /**
     * @param $token
     * @return bool
     */
    public function emailConfirm ($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Token cannot be blank.');
        }

        $user = $this->userRepository->findByParams(['email_confirmation_token' => $token]);

        if (!$user) {
            throw new InvalidParamException('Wrong token.');
        }

        $user->email_status = $user::EMAIL_STATUS_ACTIVE;
        $user->email_confirmation_token = NULL;
        $this->userRepository->saveUser($user);

        return true;
    }

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public function findByEAuth ($service)
    {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $soc_id = $service->getId();

        $fieldName = $this->getFieldNameBySocialNetworkAlias($service->getServiceName());

        if (!$fieldName) {
            throw new ErrorException('Unknown social field.');
        }

        if (!$service->getAttribute('email')) {
            throw new ErrorException('Не указан email адрес. Повторите попытку, выбрав в доступных данных пользователя поле email.');
        }

        if (!$this->userRepository->findByParams([$fieldName => $soc_id])) {

            if ($user = $this->userRepository->findByParams(['email' => $service->getAttribute('email')])) {
                $user->$fieldName = $soc_id;
                $user = $this->userRepository->saveUser($user);
            } else {
                $model = new User;
                $model->$fieldName = $soc_id;
                $model->name_ru = $service->getAttribute('first_name');
                $model->surname_ru = $service->getAttribute('last_name');
                $model->email = $service->getAttribute('email');
                $model->email_status = $model::EMAIL_STATUS_ACTIVE;
                $model->setPassword(Yii::$app->security->generateRandomString());
                $model->generateAuthKey();

                $user = $this->userRepository->saveUser($model);

                $profile = $this->userRepository->getProfile($user->id);

                $profile->gender = !empty($service->getAttribute('gender')) ? $service->getAttribute('gender') : NULL;
                $this->userRepository->saveProfile($profile);
            }
        } else {
            $user = $this->userRepository->findByParams([$fieldName => $soc_id]);
        }

        return $user;
    }

    private function getFieldNameBySocialNetworkAlias ($alias)
    {
        $fieldName = false;

        switch ($alias) {
            case 'facebook' :
                $fieldName = 'facebook_id';
                break;
            case 'google_oauth' :
                $fieldName = 'google_id';
                break;
        }

        return $fieldName;
    }
}