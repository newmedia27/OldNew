<?php

namespace app\modules\cart\helpers;

use yii\di\Container;

/**
 * Class OrderFormHelper
 * @package app\modules\cart\helpers
 */
class OrderFormHelper
{
    /**
     * @param $id
     * @return mixed
     */
    public static function getProductPrice ($id)
    {
        return self::getOrderService()->getProdTotalPrice($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getProductQuantity ($id)
    {
        return self::getOrderService()->getOrderData()['products'][$id];
    }

    public static function getTotalQuantity ()
    {
        return self::getOrderService()->getTotalProductsCount();
    }

    public static function getTotalSummary ()
    {
        return self::getOrderService()->getOrderSummary()['totalSum'];
    }
    /**
     * @return \app\modules\cart\components\services\OrderService
     */
    private static function getOrderService ()
    {
        $container = new Container;

        return $container->get('app\modules\cart\components\services\OrderService');
    }

    /**
     * @return \app\modules\cart\components\repository\DeliveryTypeRepository
     */
    private static function getDeliveryTypeRepository ()
    {
        $container = new Container;

        return $container->get('app\modules\cart\components\repository\DeliveryTypeRepository');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getDeliveryTypes ()
    {
        return self::getDeliveryTypeRepository()->findAll();
    }

    /**
     * @param $sum
     * @param $delivery
     * @return mixed
     */
    public static function getTotalSum ($sum, $delivery)
    {
        return $sum + $delivery;
    }

    /**
     * @param $order
     * @param $products
     * @param $sessionProducts
     * @param $discount
     * @return string
     */
    public static function generateEmailToAdmin ($order, $products, $sessionProducts, $discount)
    {
        $text = '';
        $text .= 'Клиент: ' . $order->FIO . ' Сделал новый заказ.<br>Контакты: <br>' . $order->phone . '<br>' . $order->email . '<br><br>';
        $text .= '<table>';
        foreach ($products as $product) {
            $text .= '<tr><td>' . $product->name . '</td><td>' . $sessionProducts[$product->id] . 'шт.</td><td>' . $product['prices'][0]->price . 'грн.</td></tr>';
        }
        $text .= '<tr><td>Скидка:</td><td>' . $discount . '%.</td></tr>';
        $text .= '<tr><td>Всего к оплате с доставкой:</td><td>' . $order->sum_with_discount . 'грн.</td></tr>';
        $text .= '</table>';
        $text .= '<br>';

        return $text;
    }
}