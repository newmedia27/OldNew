<?php

namespace app\modules\shop\controllers;

use app\components\helpers\PathHelper;
use app\components\repositories\CmsAttributesRepository;
use app\modules\comments\models\Comments;
use app\modules\shop\components\repositories\ShopCategoryRepository;
use app\modules\shop\models\search\ShopProductsSearch;
use app\modules\shop\models\ShopCategory;
use app\modules\shop\models\ShopProducts;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\HttpException;
use app\modules\shop\models\Currency;
use yii\helpers\ArrayHelper;
use yii\sphinx\Query;

/**
 * Shop controller for the `shop` module
 */
class ShopController extends Controller
{

    private $categoryRepository;
    private $cmsAttributesRepository;

    /**
     * @var ShopProductsSearch
     */
    private $searchModel;

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function __construct($id, $module, $config = [], ShopCategoryRepository $categoryRepository, CmsAttributesRepository $cmsAttributesRepository, ShopProductsSearch $searchModel
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->cmsAttributesRepository = $cmsAttributesRepository;
        $this->searchModel = $searchModel;

        parent::__construct($id, $module, $config);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCatalog()
    {
        $data = $this->searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->request->post());
        $queryParams = \Yii::$app->request->queryParams;


        if (\Yii::$app->request->isAjax) {

            $data['dataProvider']->pagination = false;

            return $this->renderAjax('_products_widget', [
                'dataProvider' => $data['dataProvider'],
                'maxPrice' => $data['maxPrice'] * \Yii::$app->params['currency'],
                'page' => \Yii::$app->request->queryParams['page']
            ]);
        }

        return $this->render('catalog', [
            'searchModel' => $this->searchModel,
            'dataProvider' => $data['dataProvider'], 'maxPrice' => $data['maxPrice'] * \Yii::$app->params['currency'],
            'queryParams' => $queryParams,
            'cat' => ShopCategory::find()->where(['id' => 1])->one(),
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($category = false, $category1 = false, $category2 = false)
    {
        if ($category2)
            $cat = ShopCategory::find()->where(['alias' => $category2])->one();
        else
            $cat = ShopCategory::find()->where(['alias' => $category1])->one();

        /*
          if (PathHelper::categoryPath($cat) != '/'.\Yii::$app->request->pathInfo){
          throw new HttpException(404, 'sThe requested page is not found');
          } */

        $data = $this->searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->request->post());
        $queryParams = \Yii::$app->request->queryParams;

        if (\Yii::$app->request->isAjax) {

            $data['dataProvider']->pagination = false;

            return $this->renderAjax('_products_widget', [
                'dataProvider' => $data['dataProvider'], 'maxPrice' => $data['maxPrice'] * \Yii::$app->params['currency'],
                'page' => \Yii::$app->request->queryParams['page']
            ]);
        }

        return $this->render('index', [
            'searchModel' => $this->searchModel,
            'dataProvider' => $data['dataProvider'], 'maxPrice' => $data['maxPrice'] * \Yii::$app->params['currency'],
            'queryParams' => $queryParams,
            'cat' => $cat
        ]);
    }

    public function actionSearch($q = '')
    {
        if (preg_match("~/~", $q)) {
            $arr = explode('/', $q);
            $q = implode('\\\/', $arr);
        }


//        $sql = "SELECT * FROM idx_shop_products_content WHERE MATCH ('$q')limit 1000 OPTION ranker = SPH04";
//        $sql(['field_weights']=>['name_ru'=>10, 'description'=>5]);

        $sql = new Query();

        $dataName = $sql->from('idx_shop_products_content')->match($q)->limit(100)->addOptions(['ranker'=>'WORDCOUNT'])->all();


        $dataDescription = $sql->from('idx_shop_products_desc_content')->match($q)->limit(100)->addOptions(['ranker'=>'WORDCOUNT'])->all();


//        $data = \Yii::$app->sphinx->createCommand($sql)->queryAll();


        $idn = ArrayHelper::map($dataName, 'id', 'id');
        $idd = ArrayHelper::map($dataDescription, 'id', 'id');

        $query = ShopProducts::find()->where(['id' => $idn])->union(ShopProducts::find()->where(['id' => $idd]));
        $queryDescription = ShopProducts::find()->where(['id' => $idd])->orderBy("quantity DESC");

//        $query = $queryName->union($queryDescription);




        $totalCountWithoutFiltering = clone $query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
                'totalCount' => $totalCountWithoutFiltering->count(),
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ],
        ]);


        return $this->render('found_1', [
                'dataProvider' => $dataProvider,
                'count' => $totalCountWithoutFiltering->count()
            ]
        );
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCategory($category)
    {

        $cat = ShopCategory::find()->where(['alias' => $category1])->one();

        if (!isset($cat)) {
            $cat = ShopCategory::find()->where(['alias' => \Yii::$app->request->queryParams['category']])->one();
        }

        if (count($cat->idProds) > 0) {
            if (PathHelper::categoryPath($cat) != '/' . \Yii::$app->request->pathInfo && !isset($_GET['page'])) {
                throw new HttpException(404, 'The requested page is not found');
            }
            $data = $this->searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->request->post());

            $queryParams = \Yii::$app->request->queryParams;
            if (\Yii::$app->request->isAjax) {

                $data['dataProvider']->pagination = false;

                return $this->renderAjax('_products_widget', [
                    'dataProvider' => $data['dataProvider'], 'maxPrice' => $data['maxPrice'] * \Yii::$app->params['currency'],
                    'page' => \Yii::$app->request->queryParams['page']
                ]);
            }

            return $this->render('index', [
                'searchModel' => $this->searchModel,
                'dataProvider' => $data['dataProvider'], 'maxPrice' => $data['maxPrice'] * \Yii::$app->params['currency'],
                'queryParams' => $queryParams,
                'cat' => $cat,
            ]);
        }

        if (PathHelper::categoryPath($cat) != '/' . \Yii::$app->request->pathInfo) {
            throw new HttpException(404, 'The requested page is not found');
        }
        $data = $this->searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->request->post());
        $queryParams = \Yii::$app->request->queryParams;
        if (\Yii::$app->request->isAjax) {

            $data['dataProvider']->pagination = false;

            return $this->renderAjax('_products_widget', [
                'dataProvider' => $data['dataProvider'], 'maxPrice' => $data['maxPrice'] * \Yii::$app->params['currency'],
                'page' => \Yii::$app->request->queryParams['page']
            ]);
        }
        return $this->render('subcat', [
            'queryParams' => $queryParams,
            'dataProvider' => $data['dataProvider'], 'maxPrice' => $data['maxPrice'] * \Yii::$app->params['currency'],
            'cat' => $cat,
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView()
    {
        $prod = ShopProducts::find()->where(['alias' => $_GET['prod']])->one();

        $comments = Comments::find()->where(['type' => 'products', 'id_obj' => $prod->id, 'status' => '333'])->count();

        if (!$_SESSION['products'][$prod->alias]) {
            $_SESSION['products'][$prod->alias] = $prod->id;
        }

        if (PathHelper::productPath($prod) != '/' . \Yii::$app->request->pathInfo) {
            throw new HttpException(404, 'The requested page is not found');
        }


        return $this->render('view', [
            'prod' => $prod,
            'comments' => $comments,
            'video' => $this->cmsAttributesRepository->findAttributesWithValuesByParams(12, $prod->id, 1, 'product'),
            'code_prod' => $this->cmsAttributesRepository->findAttributesWithValuesByParams(11, $prod->id, 1, 'product'),
            'naznachenie' => $this->cmsAttributesRepository->findAttributesWithValuesByParams(10, $prod->id, 1, 'product'),
            'prevprice' => $this->cmsAttributesRepository->findAttributesWithValuesByParams(1, $prod->id, 1, 'product'),
            'rashod' => $this->cmsAttributesRepository->findAttributesWithValuesByParams(8, $prod->id, 2, 'product'),
        ]);
    }

    public function actionIndexing()
    {

        /** @var \himiklab\yii2\search\Search $search */
        $search = \Yii::$app->search;
        $search->index();
        exit('ss');
    }

}
