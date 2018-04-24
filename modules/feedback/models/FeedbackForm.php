<?php

namespace app\modules\feedback\models;

use Yii;
use yii\base\Model;

class FeedbackForm extends Model
{
    const SCENARIO_SPIVPRATSIA = 'spivpratsia';
    const SCENARIO_CONTACTS = 'contacts';

    public $id;
    public $name;
    public $surname;
    public $phone;
    public $email;
    public $type;
    public $comments;
    public $gender;
    public $skype;
    public $created_time;
    public $id_obj;
    public $id_user;
    public $visit_date;
    public $visit_time;
    public $doctor;
    public $sex;
    public $status;

    public function rules()
    {
        return [
            [['type', 'comments', 'gender'], 'string'],
            [['created_time', 'visit_date', 'visit_time'], 'safe'],
            [['id_obj', 'id_user', 'status'], 'integer'],
            [['name', 'surname'], 'string','min'=> 2, 'max' => 32,'tooShort' => Yii::t('trans', 'name_field'),'tooLong'=> Yii::t('trans', 'name_field')],
            [['name'], 'required', 'message' => Yii::t('trans', 'obligatory_field')],
            [['phone'], 'string', 'max' => 20],
            [['email', 'skype', 'doctor', 'sex'], 'string', 'max' => 255],
            [['email'], 'required', 'message' => Yii::t('trans', 'email_required')],
            [['name', 'phone','email','id_obj'], 'required', 'on' => self::SCENARIO_SPIVPRATSIA],
            [['name', 'comments','email'], 'required', 'on' => self::SCENARIO_CONTACTS],
        ];
    }

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