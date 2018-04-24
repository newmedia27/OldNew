<?php

namespace app\modules\cart\components\repository;

use app\modules\cart\models\Order;
use yii\base\Exception;
use yii\base\InvalidParamException;

/**
 * Class OrderRepository
 * @package app\modules\cart\components\repository
 */
class OrderRepository
{
    /**
     * @param $userId
     * @return int|\yii\db\ActiveRecord[]
     */
    public function getUserOrdersSum ($userId)
    {
        if (!$userId) {
            throw new InvalidParamException('User id missing!');
        }

        return Order::find()->where(['id_user' => $userId])->sum('sum_with_discount');
    }

    /**
     * @param $model
     * @return mixed
     * @throws Exception
     */
    public function saveOrderData ($model)
    {

        if (!$model->save()) {
            var_dump($model->getErrors());die;
            throw new Exception('Can`t save order.');
        }

        return $model->id;
    }

    /**
     * @param $model
     * @throws Exception
     */
    public function saveJoinedProducts ($model)
    {
        if (!$model->save()) {
            throw new Exception('Can`t save order.');
        }
    }

    /**
     * @param $model
     * @throws Exception
     */
    public function saveDelivery ($model)
    {
        if (!$model->save()) {
            throw new Exception('Can`t save order.');
        }
    }
}