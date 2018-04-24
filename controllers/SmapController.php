<?php

namespace app\controllers;

use app\models\SmapPages;
use HttpException;
use Yii;
use yii\web\Controller;

class SmapController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->getQueryParam('alias1')) $alias_arr[] = Yii::$app->request->getQueryParam('alias1');
        if (Yii::$app->request->getQueryParam('alias2')) $alias_arr[] = Yii::$app->request->getQueryParam('alias2');
        if (Yii::$app->request->getQueryParam('alias3')) $alias_arr[] = Yii::$app->request->getQueryParam('alias3');
        $alias = $alias_arr[count($alias_arr) - 1];

        if ($alias) {
            $model = SmapPages::find()->where(['alias' => $alias])->all();
            if (empty($model)) {
                throw new HttpException(404, 'The requested page is not found');
            }
            if ($alias == 'contacts') {
                return $this->render('contacts', ['model' => $model, 'alias_arr' => $alias_arr]);
            }
            return $this->render('index', ['model' => $model, 'alias_arr' => $alias_arr]);
        }
    }

    public function actionOther()
    {
        if (Yii::$app->request->getQueryParam('alias1')) $alias_arr[] = Yii::$app->request->getQueryParam('alias1');
        $alias = $alias_arr[count($alias_arr) - 1];

        if ($alias) {
            $model = SmapPages::find()->where(['alias' => $alias,'id_class'=>6])->all();
            if (empty($model)) {
                throw new HttpException(404, 'The requested page is not found');
            }
            return $this->render('index', ['model' => $model, 'alias_arr' => $alias_arr]);
        }
    }

}