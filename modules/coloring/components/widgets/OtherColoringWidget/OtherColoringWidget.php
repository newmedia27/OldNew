<?php

namespace app\modules\coloring\components\widgets\OtherColoringWidget;

use app\modules\shop\components\helpers\PaginatorHelper;
use app\modules\shop\components\repositories\ShopCategoryRepository;
use app\modules\shop\models\ShopProducts;
use yii\base\Widget;

class OtherColoringWidget extends Widget
{

    public $prod;

    public function run ()
    {
        $shopCategoryRepository = new ShopCategoryRepository();
        $cat = $shopCategoryRepository->findCategoryByAlias('coloring');

        $coloring = ShopProducts::find()->joinWith('shopProdJoinCats')
            ->andFilterWhere(['shop_prod_join_cat.id_cat'=> $cat->id])->limit(3)->all();

        return $this->render('index', [
            'coloring' => $coloring,
        ]);

    }
}