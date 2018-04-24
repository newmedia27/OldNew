<?php

namespace app\modules\shop\components\widgets\FiltersViewsWidget;

use yii\base\Widget;

class FiltersViewsWidget extends Widget
{
    public $attr;
    public $form;

    public function run ()
    {
        return $this->render($this->attr->type, [
            'form' => $this->form,
            'attr' => $this->attr
        ]);
    }
}