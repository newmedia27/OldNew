<?php

namespace app\modules\comments\components\services;

use app\modules\comments\components\repository\CommentsRepository;
use app\modules\comments\models\Comments;

/**
 * Class CommentsService
 * @package app\modules\comments\components\services
 */
class CommentsService
{
    /**
     * @var CommentsRepository
     */
    private $commentsRepository;

    /**
     * CommentsService constructor.
     * @param CommentsRepository $commentsRepository
     */
    public function __construct (CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    public function addComment ($data)
    {
        $model = new Comments;
        $model->attributes = $data;

        $this->commentsRepository->save($model);
    }

    /**
     * @param $idObj
     * @param $type
     * @param $idPar
     * @return array|\app\modules\comments\models\Comments[]
     */
    public function getCommentsList ($idObj, $type, $idPar = 0)
    {
        return $this->commentsRepository->findAll($idObj, $type, $idPar);
    }
}