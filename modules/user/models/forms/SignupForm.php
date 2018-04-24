<?php
namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $login;
    public $surname;
    public $secondname;
    public $agreement;
    public $password_repeat;
    public $email;
    public $password;
    public $phone;
    public $address;
    public $city;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','surname', 'secondname', 'email', 'phone', 'city', 'address'], 'filter', 'filter' => 'trim'],
            [['username','surname','login', 'email', 'password'], 'required'],
            ['email', 'unique', 'targetClass' => '\app\modules\user\models\User', 'message' => 'Этот email уже занят'],
            ['phone', 'unique', 'targetClass' => '\app\modules\user\models\User', 'message' => 'Этот телефон уже занят'],
            [['username','surname', 'secondname'], 'string', 'min' => 2, 'max' => 255],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            [['city', 'address'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя*:',
            'surname' => Yii::t('trans', 'surname'),
            'secondname' => 'По-батькові*:',
            'phone' => 'Телефон*:',
            'email' => 'Email*:',
            'password' => 'Введите пароль*:',
            'city' => 'Город:',
            'address' => 'Адрес:',
            'login' => 'Логин:',
            'password_repeat' => 'Повторите пароль:',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            var_dump($this->getErrors());exit();
        }

        $user = new User();
        $user->login = $this->login;
        $user->username = $this->username;
        $user->surname = $this->surname;
        $user->secondname = $this->secondname;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->city = $this->city;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save(false) ? $user : null;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail($model)
    {
        if (!$model) {
            return false;
        }

        $data['user'] = $model;
        $data['password'] = $this->password;
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'registration-html', 'text' => 'registration-text'],
                ['data' => $data]
            )
            ->setFrom(['info@colormarket.online' => 'Colormarket'])
            ->setTo([$model->email])
            ->setSubject('Регистрация')
            ->send();
    }
}
