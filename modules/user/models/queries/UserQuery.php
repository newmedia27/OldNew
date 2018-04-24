<?php

namespace app\modules\user\models\queries;

/**
 * This is the ActiveQuery class for [[\app\modules\user\models\User]].
 *
 * @see \app\modules\user\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\user\models\User[]|array
     */
    public function all ($db = NULL)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\user\models\User|array|null
     */
    public function one ($db = NULL)
    {
        return parent::one($db);
    }
}
