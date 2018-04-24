<?php

namespace app\modules\blog\components\widgets\TagViewWidget;

use app\modules\blog\components\services\NewsCategoryService;
use app\modules\news\models\Tags;
use yii\base\Widget;

class TagViewWidget extends Widget
{
    public $model;

    public function run() {
        $tags = $this->model->tags;

        return $this->render('index',[
            'tags' => $tags,
        ]);
    }
}