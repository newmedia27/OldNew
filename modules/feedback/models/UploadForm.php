<?php

namespace app\modules\feedback\models;

use yii\base\Model;

class UploadForm extends Model {

    /**
     * @var files[]
     */
    public $files;

    public function rules () {
        return [
            [['files'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 10],
        ];
    }
}