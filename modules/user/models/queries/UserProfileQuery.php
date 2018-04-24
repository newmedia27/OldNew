<?php

namespace app\modules\user\models\queries;

/**
 * This is the ActiveQuery class for [[\app\modules\user\models\UserProfile]].
 *
 * @see \app\modules\user\models\UserProfile
 */
class UserProfileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\user\models\UserProfile[]|array
     */
    public function all ($db = NULL)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\user\models\UserProfile|array|null
     */
    public function one ($db = NULL)
    {
        return parent::one($db);
    }
}
