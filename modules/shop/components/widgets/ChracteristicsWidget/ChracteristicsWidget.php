<?php

namespace app\modules\shop\components\widgets\ChracteristicsWidget;

use yii\base\Widget;

class ChracteristicsWidget extends Widget
{
    public $prod;
    public $view = 'index';

    public function run ()
    {
        $char = $this->prod->attrs;
        $cat = $this->prod->cats[0];
        foreach ($char as $attr){
            $hell[] = $attr->idTrees;
        }

        return $this->render($this->view, [
            'char' => $char,
            'id'=> $this->prod->id,
            'trees' => $cat->idTrees
        ]);
    }
}