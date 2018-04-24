<?php

namespace app\modules\news\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\news\models\Tags]].
 *
 * @see \app\modules\news\models\Tags
 */
class TagsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\news\models\Tags[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\news\models\Tags|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
