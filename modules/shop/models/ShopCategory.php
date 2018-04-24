<?php

namespace app\modules\shop\models;

use app\models\CmsAttributesTree;
use app\models\CmsFiles;
use Yii;

/**
 * This is the model class for table "shop_category".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $alias
 * @property integer $prior
 * @property integer $visible
 * @property integer $id_par
 * @property string $created
 * @property string $updated
 * @property string $seo_title_ru
 * @property string $seo_description_ru
 * @property string $seo_keywords_ru
 * @property string $seo_text_ru
 * @property integer $id_photo_type
 * @property string $description_ru
 * @property string $description_long_ru
 * @property string $name_ua
 * @property string $seo_title_ua
 * @property string $seo_description_ua
 * @property string $seo_keywords_ua
 * @property string $seo_text_ua
 * @property string $description_ua
 * @property string $description_long_ua
 *
 * @property CmsAttributesTreeJoinCat[] $cmsAttributesTreeJoinCats
 * @property CmsAttributesTree[] $idTrees
 * @property ShopProdJoinCat[] $shopProdJoinCats
 * @property ShopProducts[] $idProds
 */
class ShopCategory extends \yii\db\ActiveRecord
{
    public $name;
    public $description;
    public $description_long;
    public $seo_title;
    public $seo_h1;
    public $seo_description;
    public $seo_text;
    public $seo_keywords;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_category';
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['prior', 'visible', 'id_par', 'id_photo_type'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['seo_description_ru', 'seo_keywords_ru', 'seo_text_ru', 'description_ru', 'description_long_ru', 'seo_description_ua', 'seo_keywords_ua', 'seo_text_ua', 'description_ua', 'description_long_ua'], 'string'],
            [['seo_h1_ru','seo_h1_ua','seo_h1_en','name_ru', 'alias', 'name_ua'], 'string', 'max' => 255],
            [['seo_title_ru', 'seo_title_ua'], 'string', 'max' => 455],
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
            'alias' => 'Alias',
            'prior' => 'Prior',
            'visible' => 'Visible',
            'id_par' => 'Id Par',
            'created' => 'Created',
            'updated' => 'Updated',
            'seo_title_ru' => 'Seo Title Ru',
            'seo_description_ru' => 'Seo Description Ru',
            'seo_keywords_ru' => 'Seo Keywords Ru',
            'seo_text_ru' => 'Seo Text Ru',
            'id_photo_type' => 'Id Photo Type',
            'description_ru' => 'Description Ru',
            'description_long_ru' => 'Description Long Ru',
            'name_ua' => 'Name Ua',
            'seo_title_ua' => 'Seo Title Ua',
            'seo_description_ua' => 'Seo Description Ua',
            'seo_keywords_ua' => 'Seo Keywords Ua',
            'seo_text_ua' => 'Seo Text Ua',
            'description_ua' => 'Description Ua',
            'description_long_ua' => 'Description Long Ua',
        ];
    }

    public function afterFind ()
    {
        parent::afterFind();
        if(is_a(Yii::$app,'yii\web\Application')){
        $this->name = $this->{"name_" . Yii::$app->language};
        $this->description = $this->{"description_" . Yii::$app->language};
        $this->description_long = $this->{"description_long_" . Yii::$app->language};
        $this->seo_title = $this->{"seo_title_" . Yii::$app->language};
        $this->seo_description = $this->{"seo_description_" . Yii::$app->language};
        $this->seo_text = $this->{"seo_text_" . Yii::$app->language};
        $this->seo_keywords = $this->{"seo_keywords_" . Yii::$app->language};
        $this->seo_h1 = $this->{"seo_h1_" . Yii::$app->language};
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsAttributesTreeJoinCats()
    {
        return $this->hasMany(CmsAttributesTreeJoinCat::className(), ['id_cat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTrees()
    {
        return $this->hasMany(CmsAttributesTree::className(), ['id' => 'id_tree'])->viaTable('cms_attributes_tree_join_cat', ['id_cat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopProdJoinCats()
    {
        return $this->hasMany(ShopProdJoinCat::className(), ['id_cat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProds()
    {
        return $this->hasMany(ShopProducts::className(), ['id' => 'id_prod'])->viaTable('shop_prod_join_cat', ['id_cat' => 'id'])->where(['visible'=>'public']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParCats()
    {
        return $this->hasOne(ShopCategory::className(), ['id' => 'id_par']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildCats()
    {
        return $this->hasMany(ShopCategory::className(), ['id_par' => 'id']);
    }

    public function getFile() {
        return $this->hasMany(CmsFiles::className(), ['id_obj' => 'id'])->andWhere(['type'=>'category'])->orderBy('date DESC');
    }
}
