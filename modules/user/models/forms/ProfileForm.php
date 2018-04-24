<?php

namespace app\modules\user\models\forms;

use yii\base\Model;

/**
 * Signup form
 */
class ProfileForm extends Model
{
    const SCENARIO_SAVE = 'save';

    public $name_ru;
    public $surname_ru;
    public $email;
    public $phone;
    public $birth_date;

    public function rules ()
    {
        return [
            [['email', 'name_ru', 'surname_ru'], 'required'],
            [['name_ru', 'surname_ru', 'email'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\modules\user\models\User', 'on' => self::SCENARIO_SAVE, 'message' => 'This email address has already been taken.'],
            ['email', 'email'],
            ['phone', 'string', 'max' => 45],
            ['birth_date', 'string', 'max' => 45],
            [['name_ru', 'surname_ru'], 'match', 'pattern' => '/^[a-zA-Zа-яА-Я0-9_-]+$/u', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
        ];
    }

}
