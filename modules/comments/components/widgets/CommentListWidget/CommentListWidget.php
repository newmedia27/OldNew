<?php

namespace app\modules\comments\components\widgets\CommentListWidget;

use app\modules\comments\components\services\CommentsService;
use yii\base\Widget;

class CommentListWidget extends Widget
{
    public $idObj;

    public $type;

    public $tpl = 'default';

    public $idPar = 0;

    private $commentsService;

    public function __construct (CommentsService $commentsService, array $config = [])
    {
        $this->commentsService = $commentsService;
        parent::__construct($config);
    }

    public function init ()
    {
        parent::init();
    }

    public function run ()
    {

        $comments = $this->commentsService->getCommentsList($this->idObj, $this->type, $this->idPar);

        return $this->render($this->tpl, [
            'comments' => $comments,
            'idObj' => $this->idObj,
            'type' => $this->type,
            'idPar' => $this->idPar,
        ]);
    }
}