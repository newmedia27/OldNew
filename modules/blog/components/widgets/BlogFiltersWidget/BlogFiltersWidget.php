<?php

namespace app\modules\blog\components\widgets\BlogFiltersWidget;

use yii\base\Widget;

class BlogFiltersWidget extends Widget
{
    public $queryParams;

    public function run ()
    {
        return $this->render('index', [
            'params' => $this->queryParams
        ]);
    }
}