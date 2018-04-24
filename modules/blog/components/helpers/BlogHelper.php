<?php

namespace app\modules\blog\components\helpers;

class BlogHelper
{
    public static function getSortingFilters ()
    {
        return [
            3 => 'Новые',
            4 => 'Старые',
            5 => 'Популярные',
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