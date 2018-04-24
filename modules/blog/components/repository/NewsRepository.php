<?php

namespace app\modules\blog\components\repository;


use app\modules\blog\models\News;

class NewsRepository
{
    public function findNewsByAliasWithCmsFiles($id, $alias)
    {
        return News::find()
            ->joinWith('newsJoinCats')
            ->where(['category_id' => $id])
            ->andWhere(['alias' => $alias])
            ->with('cmsFiles');
    }

    public function findNewsByCategory ($id)
    {
        return News::find()
            ->joinWith('newsJoinCats')
            ->where(['news_join_cat.category_id' => $id])
            ->orderBy(['news_date_start' => SORT_DESC]);
    }

    public function findNewsInSubCats ($array)
    {
        return News::find()
            ->joinWith('newsJoinCats')
            ->where(['news_join_cat.category_id' => $array])
            ->orderBy(['news_date_start' => SORT_DESC]);
    }
}