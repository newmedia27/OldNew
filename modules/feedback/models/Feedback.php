<?php

namespace app\modules\feedback\models;

use app\components\behaviors\CmsAttributesValuesBehavior;
use app\models\CmsAttributesValues;
use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $email
 * @property string $type
 * @property string $comments
 * @property string $gender
 * @property string $skype
 * @property string $created_time
 * @property integer $id_obj
 * @property integer $id_user
 * @property string $visit_date
 * @property string $visit_time
 * @property string $sex
 * @property integer $status
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    public function behaviors ()
    {
        return [
            [
                'class' => CmsAttributesValuesBehavior::className()
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'comments', 'gender'], 'string'],
            [['created_time', 'visit_date', 'visit_time'], 'safe'],
            [['id_obj', 'id_user', 'status'], 'integer'],
            [['name', 'surname'], 'string', 'max' => 70],
            [['phone'], 'string', 'max' => 45],
            [['email', 'skype', 'sex'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'phone' => 'Phone',
            'email' => 'Email',
            'type' => 'Type',
            'comments' => 'Comments',
            'gender' => 'Gender',
            'skype' => 'Skype',
            'created_time' => 'Created Time',
            'id_obj' => 'Id Obj',
            'id_user' => 'Id User',
            'visit_date' => 'Visit Date',
            'visit_time' => 'Visit Time',
            'doctor' => 'Doctor',
            'sex' => 'Sex',
            'status' => 'Status',
        ];
    }
}
