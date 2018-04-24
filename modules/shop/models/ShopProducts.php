<?php

namespace app\modules\shop\models;

use app\models\CmsAttributes;
use app\models\CmsAttributesValues;
use app\models\CmsFiles;
use app\models\DiscountUserToBrand;
use app\modules\cart\models\OrderJoinProd;
use himiklab\yii2\search\behaviors\SearchBehavior;
use app\modules\shop\models\Currency;
use Yii;

/**
 * This is the model class for table "shop_products".
 *
 * @property integer $id
 * @property integer $prior
 * @property string $name_ua
 * @property string $name_ru
 * @property string $article
 * @property string $alias
 * @property string $path
 * @property string $description_ru
 * @property string $long_description_ru
 * @property integer $id_price
 * @property integer $quantity
 * @property string $seo_title_ru
 * @property string $seo_description_ru
 * @property string $seo_keywords_ru
 * @property string $seo_text_ru
 * @property string $created
 * @property string $updated
 * @property integer $prod_view
 * @property string $description_ua
 * @property string $long_description_ua
 * @property string $seo_title_ua
 * @property string $seo_description_ua
 * @property string $seo_keywords_ua
 * @property string $seo_text_ua
 * @property string $visible
 * @property string $h1_ru
 * @property string $h1_ua
 *
 * @property OrderJoinProd[] $orderJoinProds
 * @property ShopPrices[] $shopPrices
 * @property ShopProdJoinCat[] $shopProdJoinCats
 * @property ShopCategory[] $idCats
 */
class ShopProducts extends \yii\db\ActiveRecord
{
    public $id_file;
    public $_price;
    public $name;
    public $description;
    public $long_description;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;
    public $discount;
    public $h1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prior', 'name_ru','alias', 'id_price', 'quantity'], 'required'],
            [['prior', 'id_price', 'quantity', 'prod_view'], 'integer'],
            [['path', 'id_1c','description_ru', 'long_description_ru', 'seo_description_ru', 'seo_keywords_ru', 'seo_text_ru', 'description_ua', 'long_description_ua', 'seo_description_ua', 'seo_keywords_ua', 'seo_text_ua', 'visible'], 'string'],
            [['created', 'updated'], 'safe'],
            [['name_ua', 'name_ru', 'article', 'h1_ru', 'h1_ua'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 200],
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
            'prior' => 'Prior',
            'name_ua' => 'Name Ua',
            'name_ru' => 'Name Ru',
            'article' => 'Article',
            'alias' => 'Alias',
            'path' => 'Path',
            'description_ru' => 'Description Ru',
            'long_description_ru' => 'Long Description Ru',
            'id_price' => 'Id Price',
            'quantity' => 'Quantity',
            'seo_title_ru' => 'Seo Title Ru',
            'seo_description_ru' => 'Seo Description Ru',
            'seo_keywords_ru' => 'Seo Keywords Ru',
            'seo_text_ru' => 'Seo Text Ru',
            'created' => 'Created',
            'updated' => 'Updated',
            'prod_view' => 'Prod View',
            'description_ua' => 'Description Ua',
            'long_description_ua' => 'Long Description Ua',
            'seo_title_ua' => 'Seo Title Ua',
            'seo_description_ua' => 'Seo Description Ua',
            'seo_keywords_ua' => 'Seo Keywords Ua',
            'seo_text_ua' => 'Seo Text Ua',
            'visible' => 'Visible',
            'h1_ru' => 'H1 Ru',
            'h1_ua' => 'H1 Ua',
        ];
    }

    public function afterFind ()
    {
        parent::afterFind();
        if(is_a(Yii::$app,'yii\web\Application')){
        $this->name = $this->{"name_" . \Yii::$app->language};
        $this->description = $this->{"description_" . \Yii::$app->language};
        $this->long_description = $this->{"long_description_" . \Yii::$app->language};
        $this->seo_title = $this->{"seo_title_" . \Yii::$app->language};
        $this->seo_description = $this->{"seo_description_" . \Yii::$app->language};
        $this->h1 = $this->{"h1_" . \Yii::$app->language};
        }
    }

    public function behaviors ()
    {
        return [
            'search' => [
                'class' => SearchBehavior::className(),
                'searchScope' => function($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    $model->select(['shop_products.name_ru', 'shop_products.img_path_thumb', 'shop_products.article', 'shop_products.description_ru', 'shop_products.id', 'shop_products.alias', 'shop_prices.price', 'files.id as id_file'])
                        ->from('shop_products')
                        ->join('INNER JOIN', 'shop_prices', 'id_price = shop_prices.id')
                        ->join('INNER JOIN', 'shop_prod_join_cat shpr', 'shop_products.id=shpr.id_prod')
                        ->join('INNER JOIN', 'shop_category shpc', 'shpr.id_cat=shpc.id and shpr.id_cat not in(23,22)')
                        ->join('LEFT JOIN', 'cms_files files', 'shop_products.id=files.id_obj')
                        ->where(['shop_products.visible' => 'public', 'shop_products.deleted' => 'no'])->orderBy('files.onmain DESC')->all();
                    //$model->andWhere(['indexed' => true]);
                },
                'searchFields' => function($model) {

                    /** @var self $model */
                    return [
                        ['name' => 'title', 'value' => $model->name_ru, 'type' => SearchBehavior::FIELD_KEYWORD],
                         ['name' => 'id', 'value' => $model->id],
//                        ['name' => 'prod', 'value' => $model->id],
                        ['name' => 'img', 'value' => ($model->file[0]->path_thumb?$model->file[0]->path_thumb:$model->file[0]->path)],
                        ['name' => 'article', 'value' => $model->article, 'type' => SearchBehavior::FIELD_TEXT],
                        ['name' => 'price', 'value' => $model->_price, 'type' => SearchBehavior::FIELD_KEYWORD],
                        ['name' => 'body', 'value' => strip_tags($model->description_ru)],
                        ['name' => 'url', 'value' => \app\components\helpers\PathHelper::productPath($model), 'type' => SearchBehavior::FIELD_KEYWORD],
                        ['name' => 'model', 'value' => 'Продукция', 'type' => SearchBehavior::FIELD_UNSTORED],
                    ];
                },
            ],
        ];
    }


//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getPrice ()
//    {
//        return $this->hasMany(ShopPrices::className(), ['id_prod' => 'id'])->orderBy('date desc');
//    }

    function getPrice ()
    {
        $this->getDiscount();
        $model = ShopPrices::find()->where(["id_prod" => $this->id])->orderBy('date desc')->one();
        
        if ($model !== NULL) {
            $this->price = $model->price*((100-$this->discount)/100);
        } else {
            $this->price = 0;
        }

        return round($model->price*((100-$this->discount)/100),2);
    }

    function getDiscount ()
    {
        if(is_a(Yii::$app,'yii\web\Application')){
        if (!Yii::$app->user->isGuest){

            $atr = CmsAttributes::findOne(['alias'=>'brand']);
            $val = CmsAttributesValues::findOne(['id_obj' => $this->id,'id_attr'=>$atr->id]);//'type'=>'product',
            $disc = DiscountUserToBrand::findOne(['id_user'=>Yii::$app->user->id,'id_val'=>$val->id_variant]);

            if (isset($disc)){
                $this->discount = $disc->discount;
            } else {
                $this->discount = 0;
            }
        } else {
            $this->discount = 0;
        }
    }else $this->discount = 0;
    }

    function setPrice ($value)
    {
        $this->_price = $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderJoinProds()
    {
        return $this->hasMany(OrderJoinProd::className(), ['id_prod' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(ShopPrices::className(), ['id_prod' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopProdJoinCats()
    {
        return $this->hasMany(ShopProdJoinCat::className(), ['id_prod' => 'id']);
    }

    public function getAttrs ()
    {
        return $this->hasMany(CmsAttributes::className(), ['id' => 'id_attr'])->viaTable('cms_attributes_values', ['id_obj' => 'id']);
    }

    public function getFile()
    {
        return $this->hasMany(CmsFiles::className(), ['id_obj' => 'id'])->andWhere(['type'=>'product'])->orderBy('onmain DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCats()
    {
        return $this->hasMany(ShopCategory::className(), ['id' => 'id_cat'])->viaTable('shop_prod_join_cat', ['id_prod' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\modules\shop\models\queries\ShopProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\shop\models\queries\ShopProductsQuery(get_called_class());
    }
}
