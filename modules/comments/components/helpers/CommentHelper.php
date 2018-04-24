<?php

namespace app\modules\comments\components\helpers;
use app\components\helpers\DateHelper;
use app\modules\comments\components\widgets\AnswerAdminWidget\AnswerAdminWidget;

/**
 * Class CommentHelper
 * @package app\modules\comments\components\helpers
 */
class CommentHelper
{
    /**
     * @param $name
     * @param $surname
     * @return string
     */
    public static function getCommentatorFullName($name, $surname)
    {
        return "<b>" . $name . ' ' . $surname . "</b>";
    }

    public static function getCommentTime($time)
    {
        return "<small>" . DateHelper::convertDate($time, 'dd MMMM yyyy H:m') . "</small>";
    }
}