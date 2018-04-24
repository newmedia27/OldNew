<?php

namespace app\components\helpers;


use app\modules\shop\models\ShopCategory;
use app\modules\shop\models\ShopProdJoinCat;

class PathHelper
{
    public static function productPath($prod)
    {
        $sp = ShopProdJoinCat::find()->where(['id_prod'=>$prod->id])->one();
        $cat = ShopCategory::find()->where(['id'=>$sp->id_cat])->one();
        $array[]= $cat->alias;
        $alias = self::arrayPath($cat, $array);
        return \Yii::$app->urlManager->createUrl(self::arrayToUrl(array_reverse($alias)).'/' .$prod->alias);
    }

    public static function categoryPath($cat)
    {
        $array[]= $cat->alias;
        $alias = self::arrayPath($cat, $array);

        return \Yii::$app->urlManager->createUrl(self::arrayToUrl(array_reverse($alias)));
    }

    private static function arrayPath($cat, $array){

        if ($cat->parCats != 0){
            $newCat = $cat->parCats;
            array_push($array, $newCat->alias);
            return self::arrayPath($newCat, $array);
        }
        return $array;
    }

    private static function arrayToUrl($array){
        $string='';
        foreach ($array as $element){
            $string = $string.'/'.$element;
        }
        return $string;
    }
}