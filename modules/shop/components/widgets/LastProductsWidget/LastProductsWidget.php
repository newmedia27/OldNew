<?php

namespace app\modules\shop\components\widgets\LastProductsWidget;

use app\models\CmsAttributesValues;
use app\modules\shop\models\ShopProducts;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class LastProductsWidget extends Widget
{

    public function run ()
    {
        $array = $_SESSION['products'];

        $query = ShopProducts::find()->where(['id'=> array_values($array)]);

        $provider = new ActiveDataProvider([
            'query' =>  $query
        ]);

        return $this->render('index', [
            'provider' => $provider->getModels(),
        ]);
    }
}