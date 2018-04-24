<?php

namespace app\modules\coloring\controllers;

use app\components\helpers\PathHelper;
use app\modules\coloring\models\search\ShopProductsSearch;
use app\modules\shop\models\ShopCategory;
use app\modules\shop\models\ShopProducts;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Default controller for the `paint` module
 */
class ColoringController extends Controller
{
    private $searchModel;

    public function beforeAction ($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);

    }

    public function __construct ($id, $module, $config = [],
                                 ShopProductsSearch $searchModel
    )
    {
        $this->searchModel = $searchModel;

        parent::__construct($id, $module, $config);
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = $this->searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->request->post());
        $queryParams = \Yii::$app->request->queryParams;
        $page = ShopCategory::findOne(['alias'=>'coloring']);

        if (\Yii::$app->request->isAjax) {

            $dataProvider->pagination = false;

            return $this->renderAjax('_products_widget', [
                'dataProvider' => $dataProvider,
                'page'=>$page
            ]);
        }

        return $this->render('index', [
            'searchModel' => $this->searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => $queryParams,
            'page' => $page
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView()
    {
        $tech = ShopProducts::find()->where(['alias' => $_GET['tech']])->one();

//        $tech->prod_view = $tech->prod_view + 1;
//        $tech->update();

        if (PathHelper::productPath($tech) != '/'.\Yii::$app->request->pathInfo){
            throw new HttpException(404, 'The requested page is not found');
        }
        return $this->render('view',[
            'prod' => $tech,
            'cat' => ShopCategory::find()
                ->where(['alias' => 'coloring'])
                ->one()
        ]);
    }
}
