<?php

namespace app\components\helpers;


use yii\data\Pagination;

class PaginatorHelper
{
    /**
     * @param Pagination $pages
     * @return bool
     */
    public static function isHiddenDownloadButton (Pagination $pages)
    {
        return $pages->getLimit() * ($pages->getPage() + 1) < $pages->totalCount;
    }

    /**
     * @param $currentPage
     * @param $totalPageCount
     * @return bool
     */
    public static function checkIsLastPage ($currentPage, $totalPageCount)
    {
        return $currentPage + 1 == $totalPageCount;
    }
}