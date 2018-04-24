<?php

namespace app\modules\blog\components\widgets\TagWidget;
use app\modules\blog\components\services\TagsService;

use app\modules\blog\models\NewsCategory;
use yii\base\Widget;

class TagWidget extends Widget
{
    public $category;

    public function run() {

        $service = new TagsService();
        $tags = $service->getTagsForBlogCategory($this->category);

        return $this->render('index',[
            'tags' => $tags,
        ]);
    }

}