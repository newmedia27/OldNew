<?php

namespace app\modules\coloring\models\search;

use app\models\CmsAttributesValues;
use app\modules\shop\components\repositories\ShopCategoryRepository;
use app\modules\shop\models\ShopCategory;
use app\modules\shop\models\ShopProdJoinCat;
use app\modules\shop\models\ShopProducts;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ShopProductsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class ShopProductsSearch extends ShopProducts
{

    /**
     * @var ShopCategoryRepository
     */
    private $shopCategoryRepository;


    /**
     * ShopProductsSearch constructor.
     * @param array $config
     * @param ShopCategoryRepository $shopCategoryRepository
     */
    public function __construct ($config = [], ShopCategoryRepository $shopCategoryRepository)
    {
        $this->shopCategoryRepository = $shopCategoryRepository;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
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
    public function scenarios ()
    {
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
    public function search ($params, $postParams)
    {
        $query = ShopProducts::find()->where(['visible'=>'public']);

        $cat = $this->shopCategoryRepository->findCategoryByAlias('coloring');

        $query->joinWith('shopProdJoinCats')
            ->andFilterWhere(['shop_prod_join_cat.id_cat'=> $cat->id]);

        if ($postParams['filters']) {
            $filtered = $this->findIdsFiltered($postParams['filters']);

            if ($filtered != 0){
                array_push($filtered,0);
                $query->andFilterWhere(['in','id',$filtered]);
            }
        }

        if ($postParams['sort'] == 3) {
            $query->orderBy(['created' => intval($postParams['sort'])]);
        }

        if (!$postParams['sort'] || $postParams['sort'] == 5) {
            $query->orderBy(['prod_view' => SORT_DESC]);
        }


        if ($postParams['sort'] == 6) {
            $query->joinWith('prices')->orderBy(['shop_prices.price' => SORT_ASC]);
        }

        if ($postParams['sort'] == 7) {
            $query->joinWith('prices')->orderBy(['shop_prices.price' => SORT_DESC]);
        }

        if ($postParams['sort'] == 8) {
            $array = ArrayHelper::getColumn(CmsAttributesValues::find()->where(['id_attr'=>3,'id_val'=>'on'])->all(), 'id_obj');
            array_push($array,0);
            $query->andFilterWhere(['in','id',$array]);
        }
$query->orderBy(['prior' => SORT_ASC]);

        $query->distinct();

        $countQuery = clone $query;
        $totalCountWithoutFiltering = $countQuery->count();

        $count = 20;//$postParams['count'] ? intval($postParams['count']) : 12;
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
            return $dataProvider;
        }

        return $dataProvider;
    }

    private function findIdsFiltered($array)
    {
        $filters = [];
        foreach ($array as $filter){
            if (count($filter)>1){
                array_shift($filter);
                foreach ($filter as $item){
                    $filters[] = $item;
                }
            }
        }
        if (count($filters)==0){
            return 0;
        }
        return $this->getResults($filters);

    }

    /**
     * Шукаємо айді продуктів, які входять в комбінацію
     * @param $combinations
     * @return array
     */
    private function getResults ($combinations)
    {
        $prodIds = [];

        /**
         * Пробегаем по массиву комбинаций и вытаскиваем из базы
         * id товаров, которые соответствуют критериям поиска
         */

        $inArr = $this->getText($combinations);

        $count = count($combinations);

        $sql = "SELECT t.id FROM shop_products t INNER JOIN cms_attributes_values as av ON av.id_obj = t.id
                              WHERE (av.id_variant IN $inArr)
                                GROUP BY t.id
                                  HAVING COUNT(DISTINCT av.id_variant) = $count";

        $res = \Yii::$app->db->createCommand($sql)->queryColumn();

        if ($res) {
            $res = array_map('intval', $res);
            $prodIds = array_merge($prodIds, $res);
        }

        return $prodIds;
    }

    /**
     * Створюємо строку для запиту з масиву
     * @param $array
     * @return string
     */
    private function getText ($array)
    {
        $res = '(';
        foreach ($array as $element) {
            $res = $res . $element . ', ';
        }
        return $res . '0)';

    }

    private function findCategoriesIds($cat)
    {
        if ($cat->childCats) {
            foreach ($cat->childCats as $subcat) {
                if ($subcat->childCats) {
                    foreach ($subcat->childCats as $subsubcat) {
                        if ($subsubcat->childCats) {
                            foreach ($subcat->childCats as $subsubsubcat) {
                                $array[] = $subsubsubcat->id;
                            }
                        } else {
                            $array[] = $subsubcat->id;
                        }
                    }
                } else {
                    $array[] = $subcat->id;
                }
            }
        }
        return array_values($array);
    }

}

