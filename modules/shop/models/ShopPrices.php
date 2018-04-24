<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "shop_prices".
 *
 * @property integer $id_prod
 * @property string $date
 * @property double $price
 * @property integer $id
 * @property string $currency
 *
 * @property ShopProducts $idProd
 */
class ShopPrices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    private $_price;
    
    public static function tableName()
    {
        return 'shop_prices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_prod', 'price'], 'required'],
            [['id_prod'], 'integer'],
            [['date'], 'safe'],
            [['price'], 'number'],
            [['currency'], 'string'],
            [['id_prod'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::className(), 'targetAttribute' => ['id_prod' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_prod' => 'Id Prod',
            'date' => 'Date',
            'price' => 'Price',
            'id' => 'ID',
            'currency' => 'Currency',
        ];
    }

    public function afterFind ()
    {
        parent::afterFind();
        $this->price = round($this->price*\Yii::$app->params['currency'],2);
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProd()
    {
        return $this->hasOne(ShopProducts::className(), ['id' => 'id_prod']);
    }
}
