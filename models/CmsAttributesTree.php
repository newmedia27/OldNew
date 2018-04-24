<?php

namespace app\models;

use app\modules\shop\models\ShopCategory;
use Yii;

/**
 * This is the model class for table "cms_attributes_tree".
 *
 * @property integer $id
 * @property string $name_ru
 * @property integer $prior
 * @property integer $id_par
 * @property integer $visible
 * @property string $alias
 * @property string $name_ua
 * @property string $name_en
 *
 * @property CmsAttributesJoinTree[] $cmsAttributesJoinTrees
 * @property CmsAttributes[] $idAttrs
 * @property CmsAttributesTreeJoinCat[] $cmsAttributesTreeJoinCats
 * @property ShopCategory[] $idCats
 * @property CmsAttributesValues[] $cmsAttributesValues
 */
class CmsAttributesTree extends \yii\db\ActiveRecord
{
    public $name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_attributes_tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prior', 'id_par', 'visible'], 'integer'],
            [['name_ru', 'alias', 'name_ua', 'name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'prior' => 'Prior',
            'id_par' => 'Id Par',
            'visible' => 'Visible',
            'alias' => 'Alias',
            'name_ua' => 'Name Ua',
            'name_en' => 'Name En',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsAttributesJoinTrees()
    {
        return $this->hasMany(CmsAttributesJoinTree::className(), ['id_tree' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAttrs()
    {
        return $this->hasMany(CmsAttributes::className(), ['id' => 'id_attr'])->viaTable('cms_attributes_join_tree', ['id_tree' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsAttributesTreeJoinCats()
    {
        return $this->hasMany(CmsAttributesTreeJoinCat::className(), ['id_tree' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCats()
    {
        return $this->hasMany(ShopCategory::className(), ['id' => 'id_cat'])->viaTable('cms_attributes_tree_join_cat', ['id_tree' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsAttributesValues()
    {
        return $this->hasMany(CmsAttributesValues::className(), ['id_tree' => 'id']);
    }

    public function afterFind ()
    {
        parent::afterFind();
        $this->name = $this->{"name_" . Yii::$app->language};
    }
}
