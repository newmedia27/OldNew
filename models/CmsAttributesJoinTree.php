<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cms_attributes_join_tree".
 *
 * @property integer $id_tree
 * @property integer $id_attr
 * @property integer $prior
 * @property integer $visible
 *
 * @property CmsAttributes $idAttr
 * @property CmsAttributesTree $idTree
 */
class CmsAttributesJoinTree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_attributes_join_tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tree', 'id_attr'], 'required'],
            [['id_tree', 'id_attr', 'prior', 'visible'], 'integer'],
            [['id_attr'], 'exist', 'skipOnError' => true, 'targetClass' => CmsAttributes::className(), 'targetAttribute' => ['id_attr' => 'id']],
            [['id_tree'], 'exist', 'skipOnError' => true, 'targetClass' => CmsAttributesTree::className(), 'targetAttribute' => ['id_tree' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tree' => 'Id Tree',
            'id_attr' => 'Id Attr',
            'prior' => 'Prior',
            'visible' => 'Visible',
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
}
