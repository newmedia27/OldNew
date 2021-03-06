<?php

namespace app\modules\news\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\news\models\TagsJoinObj]].
 *
 * @see \app\modules\news\models\TagsJoinObj
 */
class TagsJoinObjQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\news\models\TagsJoinObj[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\news\models\TagsJoinObj|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
