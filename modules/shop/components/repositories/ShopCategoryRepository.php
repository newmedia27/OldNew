<?php

namespace app\modules\shop\components\repositories;

use app\modules\shop\models\ShopCategory;

/**
 * Class ShopCategoryRepository
 * @package app\modules\shop\components\repositories
 */
class ShopCategoryRepository
{
    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findCategoryById($id)
    {
        return ShopCategory::find()
            ->where(['id' => $id])
            ->one();
    }

    /**
     * @param $alias
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findCategoryByAlias($alias)
    {
        return ShopCategory::find()
            ->where(['alias' => $alias])
            ->one();
    }

    /**
     * @param $id_par
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findCategoryByIdPar($id_par)
    {
        return ShopCategory::find()
            ->where(['id_par' => $id_par])
            ->orderBy(['prior' => SORT_ASC])
            ->with('idProds')
            ->all();
    }

    /**
     * @param $alias
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findCategoryByAliasAndIdPar($alias, $id_par)
    {
        return ShopCategory::find()
            ->where(['alias' => $alias, 'id_par' => $id_par])
            ->one();
    }
}