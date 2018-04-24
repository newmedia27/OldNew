<?php

namespace app\modules\coloring\components\widgets\TopFiltersWidget;

use yii\base\Widget;

class TopFiltersWidget extends Widget
{
    public $view = 'index';

    public function run ()
    {
        return $this->render($this->view);
    }
}