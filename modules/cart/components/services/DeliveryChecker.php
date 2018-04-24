<?php

namespace app\modules\cart\components\services;
use app\modules\shop\components\repositories\ShopProductsRepository;


/**
 * Class DeliveryChecker
 * @package app\modules\cart\components\services
 */
class DeliveryChecker extends BaseOrder
{
    /**
     * @var ShopProductsRepository
     */
    protected $productsRepository;

    /**
     * @var int
     */
    private static $delivery_price = 0;

    /**
     * DeliveryChecker constructor.
     * @param ShopProductsRepository $productsRepository
     */
    public function __construct (ShopProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    /**
     * @return int
     */
    public function getDeliveryPrice ()
    {

        $this->checkType();
        $this->checkOrderSum();

        return self::$delivery_price;
    }

    /**
     *
     */
    private function checkType ()
    {
        $type = $this->getOrderData()['delivery']['name'];
        if ($type == 'novaposhta' || $type == 'courier') {
            self::$delivery_price += 30;
        }
    }

    /**
     *
     */
    private function checkOrderSum ()
    {
        if ($this->getTotalSum() > 800) {
            self::$delivery_price = 0;
        }
    }
}