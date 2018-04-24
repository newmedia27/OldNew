<?php


namespace app\modules\user\controllers;

use app\models\SmapPages;
use app\modules\cart\models\Order;
use app\modules\user\components\services\UserService;
use app\modules\user\models\forms\ChangePasswordForm;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\user\components\repository\UserRepository;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use Yii;

/**
 * Class ProfileController
 * @package app\modules\cabinet\modules\customer\controllers
 */
class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var \yii\console\Request|\yii\web\Request
     */
    private $request;

    /**
     * @return array
     */
    public function behaviors ()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionPersonaldata()
    {
        $model= User::findOne(['id' => Yii::$app->user->identity->getId()]);
        $form = new ChangePasswordForm();

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }

        if ($form->load(Yii::$app->request->post()) && $form->savePassword()) {
            return $this->render('personal_data', [
                'model' => $model,
                'passwordform' =>$form,
                'page' => SmapPages::find()->where(['id_class'=>4,'alias' => 'personal_data'])->one()
            ]);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('personal_data', [
                'model' => $model,
                'passwordform' =>$form,
                'page' => SmapPages::find()->where(['id_class'=>4,'alias' => 'personal_data'])->one()
            ]);
        }

        return $this->render('personal_data', [
            'model' => $model,
            'passwordform' =>$form,
            'page' => SmapPages::find()->where(['id_class'=>4,'alias' => 'personal_data'])->one()
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionHistory()
    {
        $model= User::findOne(['id' => Yii::$app->user->identity->getId()]);
        $orders = Order::find()->where(['id_user' => $model->id])->with('orderProds')->orderBy('date DESC')->all();
        return $this->render('history', [
            'model' => $model,
            'orders' => $orders,
            'page' => SmapPages::find()->where(['id_class'=>4,'alias' => 'history'])->one()
        ]);
    }
}