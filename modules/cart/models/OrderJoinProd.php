<?php

namespace app\modules\cart\models;

use app\modules\shop\models\ShopProducts;
use app\modules\cart\models\Order;
use Yii;

/**
 * This is the model class for table "order_join_prod".
 *
 * @property integer $id
 * @property integer $id_order
 * @property integer $id_prod
 * @property integer $quantity
 * @property string $price
 *
 * @property ShopProducts $idProd
 * @property Order $idOrder
 */
class OrderJoinProd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return 'order_join_prod';
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [[['id_order', 'id_prod'], 'integer'],[['quantity'], 'number'], [['id_prod'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::className(), 'targetAttribute' => ['id_prod' => 'id']], [['id_order'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['id_order' => 'id']],];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return ['id' => 'ID', 'id_order' => 'Id Order', 'id_prod' => 'Id Prod', 'quantity' => 'Quantity', 'price' => 'Price',];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProd ()
    {
        return $this->hasOne(ShopProducts::className(), ['id' => 'id_prod']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOrder ()
    {
        return $this->hasOne(Order::className(), ['id' => 'id_order']);
    }
}
