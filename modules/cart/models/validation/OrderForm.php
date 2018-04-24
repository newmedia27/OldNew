<?php

namespace app\modules\cart\models\validation;

use yii\base\Model;

class OrderForm extends Model
{
    public $id_user;
    public $comment;
    public $email;
    public $address;
    public $delivery_type;
    public $payment_type;
    public $FIO;
    public $phone,$company,$edrpou,$bank,$mfo,$rr;


    public function rules ()
    {
        return [
            [['id_user','payment_type'], 'integer'],
            [['comment','company','edrpou','bank','mfo','rr'], 'string'],
            ['email', 'email'],
            [['address', 'delivery_type'], 'safe'],
            [['FIO', 'phone','payment_type'], 'required'],
            [['FIO', 'email'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels ()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'comment' => 'Комментарий',
            'FIO' => 'ФИО',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'total_sum' => 'Total Sum',
            'sum_with_discount' => 'Sum With Discount',
            'date' => 'Date',
            'status' => 'Status',
            'address' => 'Адрес доставки',
            'delivery_type' => 'delivery_type',
        ];
    }
}