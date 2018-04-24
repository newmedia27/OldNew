<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cms_attributes_values".
 *
 * @property integer $id
 * @property integer $id_tree
 * @property integer $id_attr
 * @property integer $id_obj
 * @property string $id_val
 * @property integer $id_variant
 * @property string $text
 *
 * @property CmsAttributes $idAttr
 * @property CmsAttributesTree $idTree
 * @property CmsAttributesVariants $idVariant
 */
class CmsAttributesValues extends \yii\db\ActiveRecord
{
    public $text;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_attributes_values';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tree', 'id_attr', 'id_obj', 'id_variant'], 'integer'],
            [['text_ru', 'text_ua'], 'string'],
            [['id_val'], 'string', 'max' => 45],
            [['type'], 'string', 'max' => 50],
            [['id_attr'], 'exist', 'skipOnError' => false, 'targetClass' => CmsAttributes::className(), 'targetAttribute' => ['id_attr' => 'id']],
            [['id_tree'], 'exist', 'skipOnError' => false, 'targetClass' => CmsAttributesTree::className(), 'targetAttribute' => ['id_tree' => 'id']],
            [['id_variant'], 'exist', 'skipOnError' => false, 'targetClass' => CmsAttributesVariants::className(), 'targetAttribute' => ['id_variant' => 'id']],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tree' => 'Id Tree',
            'id_attr' => 'Id Attr',
            'id_obj' => 'Id Obj',
            'id_val' => 'Id Val',
            'id_variant' => 'Id Variant',
            'text_ru' => 'Text Ru',
            'type' => 'Type',
            'text_ua' => 'Text Ua',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAttr()
    {
        return $this->hasOne(CmsAttributes::className(), ['id' => 'id_attr']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTree()
    {
        return $this->hasOne(CmsAttributesTree::className(), ['id' => 'id_tree']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVariant()
    {
        return $this->hasOne(CmsAttributesVariants::className(), ['id' => 'id_variant']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdVal()
    {
        return $this->hasOne(CmsAttributesVariants::className(), ['id' => 'id_val']);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->text =  $this->{"text_" . Yii::$app->language};
    }
}
