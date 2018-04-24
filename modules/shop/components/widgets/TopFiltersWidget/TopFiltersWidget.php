<?php

namespace app\modules\shop\components\widgets\TopFiltersWidget;

use yii\base\Widget;

class TopFiltersWidget extends Widget
{
    public $queryParams;
    public $view = 'index';

    public function run ()
    {
        return $this->render($this->view, [
            'params' => $this->queryParams
        ]);
    }
}