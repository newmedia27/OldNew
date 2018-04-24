<?php

namespace app\modules\comments\components\widgets\CommentFormWidget;

use app\assets\CommentAsset;
use app\modules\comments\models\forms\CommentsForm;
use yii\base\Widget;

class CommentFormWidget extends Widget
{
    public $tpl = 'index';
    public $idObj;
    public $type;
    public $idPar;

    public function init ()
    {
        parent::init();
    }

    public function run ()
    {
        return $this->render($this->tpl, [
            'model' => new CommentsForm(),
            'idObj' => $this->idObj,
            'idPar' => $this->idPar,
            'type'  => $this->type
        ]);
    }

    protected function registerClientScript ()
    {
        $view = $this->getView();
        CommentAsset::register($view);
    }
}