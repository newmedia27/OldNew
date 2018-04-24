<?php

namespace app\modules\shop\models;

use Yii;

/**
 * This is the model class for table "shop_prod_join_cat".
 *
 * @property integer $id_prod
 * @property integer $id_cat
 *
 * @property ShopCategory $idCat
 * @property ShopProducts $idProd
 */
class ShopProdJoinCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_prod_join_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_prod', 'id_cat'], 'required'],
            [['id_prod', 'id_cat'], 'integer'],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCategory::className(), 'targetAttribute' => ['id_cat' => 'id']],
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
            'id_cat' => 'Id Cat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCat()
    {
        return $this->hasOne(ShopCategory::className(), ['id' => 'id_cat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProd()
    {
        return $this->hasOne(ShopProducts::className(), ['id' => 'id_prod']);
    }
}
