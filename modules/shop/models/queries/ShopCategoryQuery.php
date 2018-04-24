<?php

namespace app\modules\shop\models\queries;

/**
 * This is the ActiveQuery class for [[ShopCategory]].
 *
 * @see ShopCategory
 */
class ShopCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\shop\models\ShopCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\shop\models\ShopCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
