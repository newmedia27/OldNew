<?php

namespace app\modules\feedback\components\repositories;

use app\modules\feedback\models\Feedback;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class FeedbackRepository
{
    public function saveFeedback(Feedback $model)
    {
        if (!$model->save()){
            throw new Exception('Smth goes wrong!');
        }
        return true;
    }
}