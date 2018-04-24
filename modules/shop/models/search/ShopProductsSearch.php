<?php

namespace app\modules\shop\models\search;

use app\models\CmsAttributesValues;
use app\modules\shop\components\repositories\ShopCategoryRepository;
use app\modules\shop\models\ShopCategory;
use app\modules\shop\models\ShopProdJoinCat;
use app\modules\shop\models\ShopProducts;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\modules\shop\models\Currency;

/**
 * ShopProductsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class ShopProductsSearch extends ShopProducts {

    /**
     * @var ShopCategoryRepository
     */
    private $shopCategoryRepository;

    /**
     * ShopProductsSearch constructor.
     * @param array $config
     * @param ShopCategoryRepository $shopCategoryRepository
     */
    public function __construct($config = [], ShopCategoryRepository $shopCategoryRepository) {
        $this->shopCategoryRepository = $shopCategoryRepository;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['prior', 'name_ru', 'article', 'alias', 'id_price', 'quantity'], 'required'],
            [['prior', 'id_price', 'quantity', 'prod_view'], 'integer'],
            [['path', 'description_ru', 'long_description_ru', 'seo_description_ru', 'seo_keywords_ru', 'seo_text_ru', 'description_ua', 'long_description_ua', 'seo_description_ua', 'seo_keywords_ua', 'seo_text_ua', 'visible'], 'string'],
            [['created', 'updated'], 'safe'],
            [['name_ua', 'name_ru', 'article', 'h1_ru', 'h1_ua'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 100],
            [['seo_title_ru', 'seo_title_ua'], 'string', 'max' => 455],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param array $postParams
     *
     * @return ActiveDataProvider
     */
    public function search($params, $getParams) {

        $currency = Currency::find()->orderBy(['date' => SORT_DESC])->limit(1)->one();

        $query = ShopProducts::find()->where(['visible' => 'public']);

        $cats = [];
        if (isset($params['category3']))
            array_push($cats, $params['category3']);
        if (isset($params['category2']))
            array_push($cats, $params['category2']);
        if (isset($params['category1']))
            array_push($cats, $params['category1']);
        if (isset($params['category']))
            array_push($cats, $params['category']);

        $cat = $this->getCat($cats);
        
        if ($cat!==NULL) {
            if ($cat->childCats) {

                $cats = $this->findCategoriesIds($cat);

                $query->joinWith('shopProdJoinCats')
                        ->andFilterWhere(['in', 'shop_prod_join_cat.id_cat', $cats]);
            } else {
                $query->innerJoin('shop_prod_join_cat cat', 'cat.id_prod=shop_products.id and cat.id_cat=' . $cat->id);
            }
        }

        // Обработка фильторов

        if (isset($postParams['filters']) && is_array($postParams['filters'])) {

            foreach ($postParams['filters'] as $k => $v)
                $filters_id[] = $k;

            $filtered = $this->findIdsFromFilter($filters_id, $postParams['filters']);
            $query->andFilterWhere(['in', '`shop_products`.id', count($filtered) == 0 ? array(0) : $filtered]);
        }
        //Фильтр по цене
        $query->joinWith('prices');
        if ($postParams['price_from'] >= 0)
            $query->andFilterWhere(['>=', 'shop_prices.price', $postParams['price_from'] / $currency->value]);
        if ($postParams['price_to'] > 0)
            $query->andFilterWhere(['<=', 'shop_prices.price', $postParams['price_to'] / $currency->value]);



        if ($postParams['sort'] == 3) {
            $query->orderBy(['created' => intval($postParams['sort'])]);
        }

        if ($postParams['sort'] == 5) {
            $query->orderBy(['prod_view' => SORT_DESC]);
        }
        if (!$postParams['sort']){
            $query->orderBy(['quantity' => SORT_DESC]);
        }


        if ($postParams['sort'] == 6) {
            $query->orderBy(['shop_prices.price' => SORT_ASC]);
        }

        if ($postParams['sort'] == 7) {
            $query->joinWith('prices')->orderBy(['shop_prices.price' => SORT_DESC]);
        }

        if ($postParams['sort'] == 8) {
            $array = ArrayHelper::getColumn(CmsAttributesValues::find()->where(['id_attr' => 3, 'id_val' => 'on'])->all(), 'id_obj');
            array_push($array, 0);
            $query->andFilterWhere(['in', 'id', $array]);
        }

        
        $maxPriceQuery = clone $query;
        $maxPrice = $maxPriceQuery->max('`shop_prices`.price');
        

        $query->distinct();

        $countQuery = clone $query;


        $totalCountWithoutFiltering = $countQuery->count();

        $count = 20; //$postParams['count'] ? intval($postParams['count']) : 12;
        $pageFrom = $postParams['pageFrom'] ? intval($postParams['pageFrom']) : 1;

        if ($postParams['page']) {
            $offset = ($pageFrom - 1) * $count;
            $query->offset($offset);
            $query->limit((intval($postParams['page']) - $pageFrom + 1) * $count);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $count,
                'totalCount' => $totalCountWithoutFiltering,
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ],
        ]);

        /**
         * Нужен для получения количества всех записей, если выключена пагинация
         */
        $dataProvider->totalCount = $totalCountWithoutFiltering;

        $this->load($params);

        if (!$this->validate()) {
            return array('maxPrice' => $maxPrice, 'dataProvider' => $dataProvider);
        }

        return array('maxPrice' => $maxPrice, 'dataProvider' => $dataProvider);
    }

    //$filtered_ids - id з попереднього фільтра
    //$filter_id - id фільтрів
    //$params
    private function findIdsFromFilter($filter_id, $params, $filtered_ids = false) {

        if (isset($filter_id) && is_array($filter_id) && count($filter_id) > 0) {

            $id = array_pop($filter_id);

            $get_ids = $this->getIdsByAttribute($id, $params[$id]);

            if ($get_ids) {
                $get_ids = array_map('intval', $get_ids);

                if ($filtered_ids) {
                    $filtered_ids = array_intersect($filtered_ids, $get_ids);
                } else {
                    $filtered_ids = $get_ids;
                }
            } else {

                $filtered_ids = [0];
            }
            return $this->findIdsFromFilter($filter_id, $params, $filtered_ids);
        } else {
            return $filtered_ids;
        }
    }

    private function getIdsByAttribute($id_attr, $params) {
        $attr_type = \Yii::$app->db->createCommand("select type from cms_attributes where id=" . $id_attr)->queryScalar();

        switch ($attr_type) {
            case 'radio':
                $sql = "SELECT p.id FROM shop_products p " .
                        "INNER JOIN cms_attributes_values as av ON av.id_obj = p.id and id_attr=$id_attr and av.id_val=$params";
                break;
            case 'select':
                $sql = "SELECT p.id FROM shop_products p " .
                        "INNER JOIN cms_attributes_values as av ON av.id_obj = p.id and id_attr=$id_attr and av.id_variant=$params";
                break;
            case 'checkbox':
                $sql = "SELECT p.id FROM shop_products p " .
                        "INNER JOIN cms_attributes_values as av ON av.id_obj = p.id and id_attr=$id_attr and av.id_variant IN (" . implode(',', $params) . ")";

                break;
        }
        //var_dump(\Yii::$app->db->createCommand($sql)->queryColumn());die;
        if ($sql)
            return \Yii::$app->db->createCommand($sql)->queryColumn();
    }

    private function findCategoriesIds($cat, $array = []) {

        if ($cat->childCats)
            foreach ($cat->childCats as $subcat)
                $array = array_merge($array, $this->findCategoriesIds($subcat));
        else
            $array[] = $cat->id;

        return array_values($array);
    }

    private function getCat($cat_array = [], $id_par = 1) {

        $cat = ShopCategory::find()->where(['alias' => array_pop($cat_array), 'id_par' => $id_par])->one();

        if (count($cat_array) > 0)
            return $this->getCat($cat_array, $cat->id);
        else
            return $cat;
    }

}
