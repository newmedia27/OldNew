<?php

namespace app\modules\user\models;
use app\modules\user\models\queries\UserProfileQuery;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name_ru
 * @property string $surname_ru
 * @property string $city_ru
 * @property string $phone
 * @property string $birth_date
 * @property string $gender
 * @property string $avatar_path
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['avatar_path', 'gender'], 'string'],
            [['phone'], 'string', 'max' => 55],
            [['birth_date'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => false, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone' => 'Телефон',
            'birth_date' => 'Дата рождения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser ()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\modules\user\models\queries\UserProfileQuery the active query used by this AR class.
     */
    public static function find ()
    {
        return new UserProfileQuery(get_called_class());
    }
}
