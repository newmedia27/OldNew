<?php


namespace app\modules\blog\components\repository;
use app\modules\blog\models\NewsCategory;


/**
 * Class CategoryRepository
 * @package app\modules\news\components\repositories
 */
class NewsCategoryRepository
{
    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findCategoryById($id)
    {
        return NewsCategory::find()
            ->where(['id' => $id])
            ->with('news')
            ->one();
    }

    /**
     * @param $alias
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findCategoryByAlias($alias)
    {
        return NewsCategory::find()
            ->where(['alias' => $alias])
            ->with('news')
            ->one();
    }

    /**
     * @param $id_par
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findCategoryByIdPar($id_par)
    {
        return NewsCategory::find()
            ->where(['id_par' => $id_par])
            ->orderBy(['prior' => SORT_ASC])
            ->with('news')
            ->all();
    }

    /**
     * @param $alias
     * @return NewsCategory
     */
    public function findCategoryByCatAlias($alias)
    {
        return NewsCategory::find()
            ->where(['alias' => $alias])
            ->one();
    }
}