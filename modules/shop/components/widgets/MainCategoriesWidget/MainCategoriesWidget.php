<?php

namespace app\modules\shop\components\widgets\MainCategoriesWidget;

use app\modules\shop\models\ShopCategory;
use yii\base\Widget;
use Yii;

class MainCategoriesWidget extends Widget
{
    public $view = 'index';
    public function run ()
    {
        return $this->render($this->view,[
            'cats' => ShopCategory::find()->where(['id_par' => 1,'visible'=>1])->orderBy('prior ASC')->all(),
            'catalog' => ShopCategory::findOne(['id'=>1])
            ]);
    }
}