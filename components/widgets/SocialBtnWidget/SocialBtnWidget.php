<?php

namespace app\components\widgets\SocialBtnWidget;

use yii\base\Widget;
use Yii;

class SocialBtnWidget extends Widget
{

    public function run ()
    {
        return $this->render('index');
    }
}