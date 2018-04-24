<?php

namespace app\modules\cart\components\repository;

use app\modules\shop\models\ShopPrices;
use yii\base\InvalidParamException;

/**
 * Class PricesRepository
 * @package app\modules\cart\components\repository
 */
class PricesRepository
{
    /**
     * @param $id - product ID
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getProductPrice ($id)
    {
        if (!$id) {
            throw new InvalidParamException('Parameter ID missed.');
        }

        return ShopPrices::find('price')->where(["id_prod" => $id])->orderBy('id desc')->asArray()->one();
    }
}