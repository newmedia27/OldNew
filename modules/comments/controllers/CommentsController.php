<?php

namespace app\modules\comments\controllers;

use app\modules\comments\components\services\CommentsService;
use app\modules\comments\models\forms\CommentsForm;
use app\modules\comments\CommentsModule;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * Class CommentsController
 * @package app\modules\comments\controllers
 */
class CommentsController extends Controller
{
    /**
     * @var
     */
    private $request;

    private $commentsService;

    public function __construct ($id, CommentsModule $module, array $config = [], CommentsService $commentsService)
    {
        $this->commentsService = $commentsService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction ($action)
    {
        $this->request = Yii::$app->request;

        return parent::beforeAction($action);
    }

    public function actionIndex ()
    {
        return $this->render('index');
    }

    /**
     * @return array
     * @throws HttpException
     */
    public function actionValidate ()
    {
        if (!$this->request->isAjax) {
            throw new HttpException(400, 'Invalid request!');
        }
        $post = $this->request->post();
        $model = new CommentsForm();

        if ($this->request->isAjax && $model->load($this->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * @return string
     * @throws HttpException
     */
    public function actionCreate ()
    {
        if (!$this->request->isAjax) {
            throw new HttpException(400, 'Invalid request!');
        }

        $model = new CommentsForm;

        if ($model->load($this->request->post()) && $model->validate()) {

            $data = $this->request->post('CommentsForm');

            $this->commentsService->addComment($data);
            return $this->renderAjax('_comments');
        }

    }

    public function actionList ()
    {
        $idObj = $this->request->post('id_obj');
        $type = $this->request->post('type');
        $idPar = $this->request->post('id_par') ? $this->request->post('id_par') : 0;

        return $this->renderAjax('_comments', [
            'idObj' => $idObj,
            'type' => $type,
            'idPar' => $idPar,
        ]);
    }

}
