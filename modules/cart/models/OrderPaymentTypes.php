<?php

namespace app\modules\cart\models;

use Yii;

/**
 * This is the model class for table "order_payment_types".
 *
 * @property integer $id
 * @property string $name
 * @property string $name_ru
 * @property string $name_uk
 * @property string $name_en
 * @property integer $visible
 */
class OrderPaymentTypes extends \yii\db\ActiveRecord
{
    public $name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_payment_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visible'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name_ru', 'name_uk', 'name_en'], 'string', 'max' => 50],
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
            'name_ru' => 'Name Ru',
            'name_uk' => 'Name Uk',
            'name_en' => 'Name En',
            'visible' => 'Visible',
        ];
    }
    public function afterFind ()
    {
        parent::afterFind();
        $this->name = $this->{"name_" . Yii::$app->language};
    }
}
