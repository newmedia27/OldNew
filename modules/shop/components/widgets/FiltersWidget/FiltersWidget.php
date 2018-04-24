<?php

namespace app\modules\shop\components\widgets\FiltersWidget;

use yii\base\Widget;

class FiltersWidget extends Widget
{
    public $cat;

    public function run ()
    {

        $trees = $this->cat->idTrees;
        $attrib =[];
        foreach ($trees as $tree){
            if ($tree->id != 1 && $tree->id != 2){
                $attr = $tree->idAttrs;
                $attrib = array_merge($attrib,$attr);
            }
        }

        return $this->render('index', [
            'attributes' => $attrib
        ]);
    }
}