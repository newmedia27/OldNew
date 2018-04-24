<?php

namespace app\modules\blog\components\widgets\BlogCategoriesWidget;

use app\modules\blog\components\services\NewsCategoryService;
use yii\base\Widget;

class BlogCategoriesWidget extends Widget
{
    public $url;

    public function run() {
        $service = new NewsCategoryService();

        $categories = $service->getSubcategoriesByAliasPar('blog');

        return $this->render('index',[
            'model' => $categories,
            'url' => $this->url
        ]);
    }
}