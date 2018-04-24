<?php

namespace app\components\widgets\CurrencySelector;

use yii\base\Widget;
use Yii;
use app\models\Languages;

class CurrencySelectorWidget extends Widget
{
    public $view = 'index';

    public function init(){}

    public function run() {
        return $this->render($this->view, [
            'current' => Languages::getCurrent(),
            'langs' => Languages::find()->where('id_lang != :current_id', [':current_id' => Languages::getCurrent()->id_lang])->andWhere(['lang_visible' => 'yes'])->all(),
        ]);
    }
}