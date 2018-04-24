<?php

namespace app\modules\blog\components\repository;

use app\modules\blog\models\Tags;


/**
 * Class TagRepository
 * @package app\components\repositories
 */
class TagRepository
{
    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findTagById($id)
    {
        return Tags::find()
            ->where(['id' => $id])
            ->one();
    }

    /**
     * @param $alias
     * @param $type
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findTagByAlias($alias, $type)
    {
        return Tags::find()
            ->where(['alias' => $alias])
            ->andWhere(['type' => $type])
            ->one();
    }

}