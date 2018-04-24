<?php
namespace app\modules\shop\components\widgets\CategoriesMenuWidget;

use app\modules\shop\models\ShopCategory;
use yii\base\Widget;

class CategoriesMenuWidget extends Widget
{
    public function run ()
    {
        $smap = ShopCategory::find()
            ->where(['id' => 1,'visible'=>1])
            ->one();;

        $categories = ShopCategory::find()
            ->where(['id_par' => $smap->id,'visible'=>1])
            ->orderBy(['prior' => SORT_ASC])
            ->all();;

        return $this->render('index',[
            'model' => $categories,
            'url' => $smap->alias
        ]);
    }

}