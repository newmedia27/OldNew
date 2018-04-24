<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "discount_user_to_brand".
 *
 * @property integer $id_user
 * @property integer $id_val
 * @property integer $discount
 */
class DiscountUserToBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount_user_to_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_val', 'discount'], 'required'],
            [['id_user', 'id_val', 'discount'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'id_val' => 'Id Val',
            'discount' => 'Discount',
        ];
    }
}
