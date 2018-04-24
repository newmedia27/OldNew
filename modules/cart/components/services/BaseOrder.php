<?php

namespace app\modules\cart\components\services;

/**
 * Class BaseOrder
 * @package app\modules\cart\components\services
 */
abstract class BaseOrder
{
    /**
     * @var \app\modules\shop\components\repositories\ShopProductsRepository
     */
    protected $productsRepository;

    /**
     * @return int
     */
    protected function getTotalSum ()
    {
        $products = $this->getOrderProducts();
        $sessionProducts = $this->getOrderData()['products'];

        $total = 0;

        if ($products) {
            foreach ($products as $item) {
                $total += $item->price * $sessionProducts[$item['id']];
                $total = round($total,2);
            }
        }

        return $total;
    }

    /**
     * @return \app\modules\shop\models\ShopProducts[]
     */
    public function getOrderProducts ()
    {
        $products = $this->getOrderData()['products'];

        if ($products) {

            $productsIds = $this->getProductIds($products);

            return $this->productsRepository->findOrderProducts($productsIds);
        }
    }

    /**
     * @param $products
     * @return array
     */
    protected function getProductIds ($products)
    {
        return array_keys($products);
    }

    /**
     * @return mixed
     */
    public function getOrderData ()
    {
        return $_SESSION['order'];
    }
}