<?php

namespace app\modules\cart\models;

use Yii;

/**
 * This is the model class for table "order_delivery".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $number
 * @property integer $index
 * @property string $date
 */
class OrderDelivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'integer'],
            [['street','country','city', 'house'],'required'],
            [['street'], 'string'],
            [['date'], 'safe'],
            [['country', 'index'], 'string', 'max' => 55],
            [['city', 'house', 'number'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'country' => 'Country',
            'city' => 'City',
            'street' => 'Street',
            'house' => 'House',
            'number' => 'Number',
            'index' => 'Index',
            'date' => 'Date',
        ];
    }

}
