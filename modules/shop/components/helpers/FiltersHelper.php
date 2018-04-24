<?php

namespace app\modules\shop\components\helpers;

use Yii;

class FiltersHelper
{
    public static function getSortingFilters ()
    {
        return [
            5 => Yii::t('trans','popular'),
            8 => Yii::t('trans','on_sales'),
            3 => Yii::t('trans','last_added'),
            6 => Yii::t('trans','cheap_expensive'),
            7 => Yii::t('trans','expensive_cheap'),

        ];
    }

    public static function getSortingCount ()
    {
        return [
            12 => '12',
            24 => '24',
            48 => '48',
        ];
    }
}