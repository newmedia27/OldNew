<?php
namespace app\components\widgets\SearchWidget;

use app\models\SmapPages;
use yii\base\Widget;

class SearchWidget extends Widget
{
    public function run() {
        return $this->render('index');
    }
}