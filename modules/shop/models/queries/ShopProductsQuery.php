<?php

namespace app\modules\shop\models\queries;

/**
 * This is the ActiveQuery class for [[\app\modules\shop\models\ShopProducts]].
 *
 * @see \app\modules\shop\models\ShopProducts
 */
class ShopProductsQuery extends \yii\db\ActiveQuery
{
    public function visible ()
    {
        return $this->andWhere(['shop_products.visible' => 'public']);
    }

    public function withFile ()
    {
        return $this->with([
            'file' => function($query) {
                $query->andWhere(['cms_files.type' => 'product']);
                $query->orderBy('cms_files.onmain DESC');
            }]);
    }

    /**
     * @inheritdoc
     * @return \app\modules\shop\models\ShopProducts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\shop\models\ShopProducts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
