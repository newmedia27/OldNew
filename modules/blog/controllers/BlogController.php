<?php

namespace app\modules\blog\controllers;

use app\models\SmapPages;
use app\modules\blog\components\repository\NewsCategoryRepository;
use app\modules\blog\components\services\NewsService;
use app\modules\blog\models\NewsSearch;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `blog` module
 */
class BlogController extends Controller
{

    public function beforeAction ($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);

    }

    private $newsCategoryRepository;

    private $newsService;

    /**
     * @var NewsSearch
     */
    private $searchModel;

    public function __construct ($id, $module, $config = [],
                                 NewsCategoryRepository $newsCategoryRepository,
                                 NewsService $newsService,
                                 NewsSearch $searchModel
    )
    {
        $this->newsCategoryRepository = $newsCategoryRepository;
        $this->newsService = $newsService;
        $this->searchModel = $searchModel;

        parent::__construct($id, $module, $config);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $page = SmapPages::find()->where(['alias' => 'blog', 'id_par' => 0, 'id_class' => 1])->one();
        if (isset($_GET['category'])){$category = $this->newsService->checkIsCategory($_GET['category']);}
        if (isset($_GET['tag'])){$tag = $this->newsService->checkIsTag($_GET['tag']);}

        $dataProvider = $this->searchModel->search(Yii::$app->request->queryParams, Yii::$app->request->post());
        $queryParams = Yii::$app->request->queryParams;

        if (Yii::$app->request->isAjax) {

            $dataProvider->pagination = false;

            return $this->renderAjax('_blog_widget', [
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('index', [
            'page' => $page,
            'category' => $category,
            'tag' => $tag,
            'searchModel' => $this->searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => $queryParams,
        ]);
    }

    public function actionView()
    {
        $category = $this->newsService->checkIsCategory($_GET['category']);
        $model = $this->newsService->checkIsBlogNews($category, $_GET['news']);
        return $this->render('view',[
            'page' => $category,
            'model'=> $model->getModels()
        ]);
    }
}
