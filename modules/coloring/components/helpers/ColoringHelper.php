<?php

namespace app\modules\coloring\components\helpers;

use Yii;

class ColoringHelper
{
    public static function getSortingFilters ()
    {
        return [
            4 => Yii::t('trans','last_added'),
            5 => Yii::t('trans','popular'),
        ];
    }
}