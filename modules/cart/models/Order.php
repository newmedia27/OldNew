<?php

namespace app\modules\cart\models;

use app\modules\shop\models\ShopProducts;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $comment
 * @property string $FIO
 * @property string $email
 * @property string $phone
 * @property string $total_sum
 * @property string $sum_with_discount
 * @property string $date
 * @property string $address
 * @property string $delivery_type
 * @property integer $status
 *
 * @property DeliveryCourier[] $deliveryCouriers
 * @property DeliveryNovaposhta[] $deliveryNovaposhtas
 * @property DeliveryPickup[] $deliveryPickups
 * @property OrderProd[] $orderProds
 */
class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['id_user', 'status'], 'integer'],
            [['comment'], 'string'],
            ['email', 'email'],
            [['date', 'total_sum', 'address', 'sum_with_discount', 'delivery_type', 'payment_type'], 'safe'],
            [['FIO', 'address', 'phone', 'payment_type'], 'required'],
            [['FIO', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProds ()
    {
        return $this->hasMany(OrderJoinProd::className(), ['id_order' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProds()
    {
        return $this->hasMany(ShopProducts::className(), ['id' => 'id_prod'])->viaTable('order_join_prod', ['id_prod' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment ()
    {
        return $this->hasOne(OrderPaymentTypes::className(), ['id' => 'payment_type']);
    }
}
