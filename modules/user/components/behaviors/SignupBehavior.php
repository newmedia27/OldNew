<?php

namespace app\modules\user\components\behaviors;

use app\modules\user\components\services\UserService;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use Yii;

/**
 * Class SignupBehavior
 * @package app\modules\user\components\behaviors
 */
class SignupBehavior extends Behavior
{
    /**
     * @var TaskService
     */
    private $userService;

    /**
     * SignupBehavior constructor.
     * @param UserService $userService
     * @param array $config
     */
    public function __construct (UserService $userService, array $config = [])
    {
        $this->userService = $userService;

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function events ()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'signup',
        ];
    }

    /**
     *
     * @param $event
     */
    public function signup ($event)
    {
        /* @var $event ->sender is an object that was returned by AR event */
        $idUser = $event->sender->id;

        $this->addRole($idUser);
        $this->createProfile($idUser);
    }

    /**
     * Creates empty profile
     *
     * @param $idUser
     */
    private function createProfile ($idUser)
    {
        $this->userService->addProfile($idUser);
    }

    /**
     * @param $idUser
     */
    private function addRole ($idUser)
    {
        $customerRole = Yii::$app->authManager->getRole('customer');
        Yii::$app->authManager->assign($customerRole, $idUser);
    }
}