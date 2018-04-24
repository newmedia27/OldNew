<?php

namespace app\modules\feedback\components\widgets\FeedbackWidget;

use app\modules\feedback\models\FeedbackForm;
use app\modules\feedback\models\UploadForm;
use yii\base\Widget;

class FeedbackWidget extends Widget
{
    public $view;
    public $id_obj = false;

    public function run() {
        return $this->render($this->view, [
            'id_obj' => $this->id_obj,
            'model' => new FeedbackForm(['scenario' => $this->view]),
            'file' => new UploadForm()
        ]);
    }
}