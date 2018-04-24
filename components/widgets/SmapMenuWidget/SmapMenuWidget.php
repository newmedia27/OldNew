<?php
namespace app\components\widgets\SmapMenuWidget;

use app\models\SmapPages;
use yii\base\Widget;

class SmapMenuWidget extends Widget
{
    public $id_class = 7;

    public function run() {
        $models = SmapPages::find()->where(['id_class' => $this->id_class,'visible_ru'=>'public_on'])->orderBy('prior')->all();

        $url_array = explode('/', \Yii::$app->request->url);

        array_shift($url_array);

        $url_last = $url_array[count($url_array)-1];

        return $this->render('index', [
            'models' => $models,
            'url' => $url_last
        ]);
    }
}