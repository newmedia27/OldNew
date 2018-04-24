<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cms_attributes".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $type
 * @property string $alias
 * @property string $paceholder
 * @property string $description_ru
 * @property integer $visible
 * @property string $description_ua
 * @property string $name_ua
 * @property string $name_en
 * @property string $description_en
 *
 * @property CmsAttributesJoinTree[] $cmsAttributesJoinTrees
 * @property CmsAttributesTree[] $idTrees
 * @property CmsAttributesValues[] $cmsAttributesValues
 * @property CmsAttributesVariants[] $cmsAttributesVariants
 */
class CmsAttributes extends \yii\db\ActiveRecord
{
    public $name;
    public $description;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'description_ru', 'description_ua', 'description_en'], 'string'],
            [['visible'], 'integer'],
            [['name_ru', 'alias', 'paceholder', 'name_ua', 'name_en'], 'string', 'max' => 255],
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
            'type' => 'Type',
            'alias' => 'Alias',
            'paceholder' => 'Paceholder',
            'description' => 'Description',
            'visible' => 'Visible',
            'description_ua' => 'Description Ua',
            'name_ua' => 'Name Ua',
            'name_en' => 'Name En',
            'description_en' => 'Description En',
        ];
    }

    public function afterFind () {

        parent::afterFind();
        $this->name = $this->{"name_" . Yii::$app->language};
        $this->description = $this->{"description_" . Yii::$app->language};
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsAttributesJoinTrees()
    {
        return $this->hasMany(CmsAttributesJoinTree::className(), ['id_attr' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTrees()
    {
        return $this->hasMany(CmsAttributesTree::className(), ['id' => 'id_tree'])->viaTable('cms_attributes_join_tree', ['id_attr' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsAttributesValues()
    {
        return $this->hasMany(CmsAttributesValues::className(), ['id_attr' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsAttributesVariants()
    {
        return $this->hasMany(CmsAttributesVariants::className(), ['id_attr' => 'id']);
    }
}
