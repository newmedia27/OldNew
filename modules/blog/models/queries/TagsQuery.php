<?php

namespace app\modules\blog\models\queries;

/**
 * This is the ActiveQuery class for [[\app\modules\blog\models\Tags]].
 *
 * @see \app\modules\blog\models\Tags
 */
class TagsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\blog\models\Tags[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\blog\models\Tags|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
