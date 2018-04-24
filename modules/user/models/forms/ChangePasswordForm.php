<?php
namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ChangePasswordForm extends Model
{
    public $old_password;
    public $password;
    public $password_repeat;

    /**
     * @var \app\modules\user\models\User
     */
    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','old_password', 'password_repeat'], 'required'],
            ['old_password', 'validatePassword'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"],
            [['password','old_password', 'password_repeat'], 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function savePassword()
    {
        $user = $this->getUser();

        $user->setPassword($this->password);

        return $user->save(false);
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword ($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    /**
     * Finds user
     *
     * @return User|null
     */
    protected function getUser ()
    {
        if ($this->_user === NULL) {
            $this->_user = User::findOne(['id'=>\Yii::$app->user->identity->id]);
        }

        return $this->_user;
    }
}
