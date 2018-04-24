<?php

namespace app\components\helpers;

/**
 * Class DateHelper
 * @package app\components\helpers
 */
class DateHelper
{
    /**
     * @param $date
     * @param $format
     * @return string
     */
    public static function convertDate ($date, $format)
    {
        return !empty($date) ? \Yii::$app->formatter->asDate($date, $format) : '';
    }
}