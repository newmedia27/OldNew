<?php

namespace app\modules\feedback\components\services;

use app\modules\feedback\components\repositories\FeedbackRepository;
use app\modules\feedback\models\Feedback;


class FeedbackService
{
    private  $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function addFeedback($post)
    {
        $saveModel = new Feedback();
        $saveModel->attributes = $post;
        return $this->feedbackRepository->saveFeedback($saveModel);
    }
}