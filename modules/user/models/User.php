<?php
namespace app\modules\user\models;

use app\modules\cart\models\OrderDelivery;
use Yii;
use yii\base\ErrorException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $login
 * @property string $username
 * @property string $surname
 * @property string $secondname
 * @property string $city
 * @property string $social_id
 * @property string $address
 * @property string $phone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $facebook_id
 * @property string $google_id
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors ()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['login','username','surname', 'secondname', 'phone', 'address', 'city'], 'filter', 'filter' => 'trim'],
            [['login','username','surname', 'secondname','facebook_id', 'google_id'], 'string', 'min' => 2, 'max' => 255],
            ['password_hash', 'string', 'min' => 6],
            ['phone', 'safe'],
            ['email', 'unique', 'targetClass' => '\app\modules\user\models\User', 'message' => 'Этот email уже занят'],
            ['login', 'unique', 'targetClass' => '\app\modules\user\models\User', 'message' => 'Этот login уже занят'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['address', 'city'], 'safe'],
        ];
    }


    public function attributeLabels ()
    {
        return [
            'username' => 'ФИО:',
            'phone' => 'Телефон:',
            'email' => 'Email*:',
            'password_hash' => 'Пароль:',
            'address' => 'Адрес:',
            'city' => 'Город:',
            'login' => 'Логин:',
            'password_repeat' => 'Повторите пароль:',
        ];
    }

    public $profile;
    public $authKey;

    public static function findIdentity ($id)
    {
        if (Yii::$app->getSession()->has('user-' . $id)) {
            return new self(Yii::$app->getSession()->get('user-' . $id));
        } else {
            return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }

    }

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth ($service)
    {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $soc_id = $service->getServiceName() . '-' . $service->getId();

        $model = new User;

        if (!User::find()->where(['social_id' => $soc_id])->exists()) {

            $model->social_id = $soc_id;
            $model->username = $service->getAttribute('name');
            $model->save();

            $id = $model->id;
        } else {
            $user = User::find()->where(['social_id' => $soc_id])->one();
            $id = $user->id;
        }

        $attributes = [
            'id' => $id,
            'username' => $service->getAttribute('name'),
            'authKey' => md5($id),
            'profile' => $service->getAttributes(),
        ];
        $attributes['profile']['service'] = $service->getServiceName();
        Yii::$app->getSession()->set('user-' . $id, $attributes);

        return new self($attributes);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken ($token, $type = NULL)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername ($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByLogin ($login)
    {
        return static::findOne(['login' => $login, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail ($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken ($token)
    {
        

        return static::findOne([
            'password_reset_token' => $token,
            
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid ($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId ()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey ()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey ($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword ($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword ($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey ()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken ()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken ()
    {
        $this->password_reset_token = NULL;
    }
}