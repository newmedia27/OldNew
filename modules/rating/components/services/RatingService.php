<?php

namespace app\modules\rating\components\services;


use app\modules\rating\components\repositories\RatingRepository;

/**
 * Class RatingService
 * @package app\modules\rating\components\services
 */
class RatingService
{
    /**
     * @var RatingRepository
     */
    private  $ratingRepository;

    /**
     * RatingService constructor.
     * @param RatingRepository $ratingRepository
     */
    public function __construct(RatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * @param $post
     * @return bool
     */
    public function addRating($post)
    {
        $saveModel = new \app\modules\rating\models\Rating();
        $saveModel->attributes = $post;
        return $this->ratingRepository->saveRating($saveModel);
    }

    /**
     * @param $idObj
     * @param $type
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getRating($idObj, $type)
    {
        return $this->ratingRepository->findRatingTotalByIdObjType($idObj, $type);
    }

    /**
     * @param $idComment
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getRatingByIdComment($idComment)
    {
        return $this->ratingRepository->findRatingByIdComment($idComment);
    }

    /**
     * @param $post
     * @return bool
     */
    public function checkIsVotedByUser($post)
    {
        $saveModel = new \app\modules\rating\models\Rating();
        $saveModel->attributes = $post;
        return $this->ratingRepository->saveRating($saveModel);
    }
}