<?php

namespace app\components;

use app\models\Languages;
use app\modules\shop\models\ShopCategory;
use app\modules\shop\models\ShopProdJoinCat;
use yii\base\Object;
use app\models\SmapPages;

class BreadcrumbsGen extends Object
{
    public static function getProductBreadcrumbs($product)
    {
        $sp = ShopProdJoinCat::find()->where(['id_prod'=>$product->id])->one();
        $cat = ShopCategory::find()->where(['id'=>$sp->id_cat])->one();
        $array[]= $cat;
        $alias = self::arrayPath($cat, $array);
        $alias = array_reverse($alias);
        $string = "";
        foreach ($alias as $el){
            $string = $string.'/'.$el->alias;
            $breadcrumbs[] = ['label' => $el->name, 'url'=> [$string]];
        }
        $breadcrumbs[] = ['label' => $product->name, 'url'=> [$string.'/'.$product->alias]];
        return $breadcrumbs;
    }

    public static function getCatalogBreadcrumbs($cat)
    {
        $cat = ShopCategory::find()->where(['id'=>$cat->id])->one();
        $array[]= $cat;
        $alias = self::arrayPath($cat, $array);
        $alias = array_reverse($alias);
        $string = "";
        foreach ($alias as $el){
            $string = $string.'/'.$el->alias;
            $breadcrumbs[] = ['label' => $el->name, 'url'=> [$string]];
        }
        return $breadcrumbs;
    }

    private static function arrayPath($cat, $array){

        if ($cat->parCats != 0){
            $newCat = $cat->parCats;
            array_push($array, $newCat);
            return self::arrayPath($newCat, $array);
        }
        return $array;
    }

    public static function getCabinetBreadcrumbs($cab)
    {
        $breadcrumbs[] = ['label' => 'Кабинет'];
        $breadcrumbs[] = ['label' => $cab->name];
        return $breadcrumbs;
    }

    public static function getNewsBreadcrumbs($model)
    {
        $breadcrumbs[] = ['label' => 'Блог', 'url' => ['/blog']];
        $breadcrumbs[] = ['label' => $model->categories[0]->name, 'url' => ['/blog/'.$model->categories[0]->alias]];
        $breadcrumbs[] = ['label' => $model->name];
        return $breadcrumbs;
    }

    public static function getSmapBreadcrumbs($model)
    {
        $breadcrumbs[] = ['label' => $model->name];
        return $breadcrumbs;
    }

}