<?php

namespace app\modules\comments\models\queries;

/**
 * This is the ActiveQuery class for [[\app\modules\comments\models\Comments]].
 *
 * @see \app\modules\comments\models\Comments
 */
class CommentsQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $idObj
     * @param $type
     * @return $this
     */
    public function byEntity ($idObj, $type)
    {
        return $this->andWhere(['id_obj' => $idObj, 'type' => $type]);
    }

    public function newest ()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }

    public function status($status = 333)
    {
        return $this->andWhere(['status' => $status]);
    }

    /**
     * @inheritdoc
     * @return \app\modules\comments\models\Comments[]|array
     */
    public function all ($db = NULL)
    {
        return parent::all($db);
    }

    /**
     * @return $this
     */
    public function withUser ()
    {
        return $this->joinWith(['users' => function ($query) {
            $query->joinWith('userProfiles');
        }]);
    }

    /**
     * @return $this
     */
    public function withChildren ()
    {
      return $this->with('children');
    }
    /**
     * @return $this
     */
    public function withRaiting()
    {
        return $this->with('raiting');
    }

    /**
     * @inheritdoc
     * @return \app\modules\comments\models\Comments|array|null
     */
    public function one ($db = NULL)
    {
        return parent::one($db);
    }
}
