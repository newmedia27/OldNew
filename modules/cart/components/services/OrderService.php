<?php

namespace app\modules\cart\components\services;

use app\components\EmailSender;
use app\modules\shop\components\repositories\ShopProductsRepository;
use app\modules\cart\components\repository\OrderRepository;
use app\modules\cart\components\repository\PricesRepository;
use app\modules\cart\components\services\BaseOrder;

use app\modules\cart\models\Order;
use app\modules\cart\models\OrderJoinProd;
use yii\base\InvalidParamException;
use yii\di\Container;

/**
 * Class OrderService
 * @package app\modules\cart\components\services
 */
class OrderService extends BaseOrder
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ShopProductsRepository
     */
    protected $productsRepository;

    /**
     * @var PricesRepository
     */
    private $pricesRepository;

    /**
     * @var \Yii\di\Container
     */
    private $container;


    /**
     * OrderService constructor.
     * @param OrderRepository $orderRepository
     * @param ShopProductsRepository $productsRepository
     * @param PricesRepository $pricesRepository
     */
    public function __construct(
        OrderRepository $orderRepository, ShopProductsRepository $productsRepository,
        PricesRepository $pricesRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->productsRepository = $productsRepository;
        $this->pricesRepository = $pricesRepository;
        $this->container = new Container;
    }

    /**
     * @return array
     */
    public function getOrderSummary()
    {
        $summary = [];

        $summary['totalSum'] = $this->getTotalSum();

        return $summary;
    }

    /**
     * @param $id
     * @return bool
     */
    public function addProduct($id, $quantity)
    {
        if (!$id) {
            throw new InvalidParamException('Parameter id required.');
        }
        if ($quantity < 0) {
            $quantity = 0;
        }
        $productsInCart = [];
        $sessionProducts = $this->getOrderData()['products'];

        //Если в корзине уже есть товары, заполняем массив
        if (!empty($sessionProducts)) {
            $productsInCart = $sessionProducts;
        }
        //Если товар уже есть в корзине, но пользователь добавляет еще один,
        //то увеличиваем количество

        //Добавляем новый товар в корзину
        $productsInCart[$id] = $quantity;
        $_SESSION['order']['products'] = $productsInCart;

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function addProducts($id, $count)
    {
        if (!$id) {
            throw new InvalidParamException('Parameter id required.');
        }

        $productsInCart = [];
        $sessionProducts = $this->getOrderData()['products'];

        //Если в корзине уже есть товары, заполняем массив
        if (!empty($sessionProducts)) {
            $productsInCart = $sessionProducts;
        }
        //Если товар уже есть в корзине, но пользователь добавляет еще один,
        //то увеличиваем количество

        if (array_key_exists($id, $productsInCart)) {

            $productsInCart[$id] = $productsInCart[$id] + $count;

        } else {
            //Добавляем новый товар в корзину
            $productsInCart[$id] = $count;
        }
        $_SESSION['order']['products'] = $productsInCart;

        return true;
    }

    /**
     * @param $id
     * @param bool|false $force
     * @return bool
     */
    public function deleteProduct($id, $force = false, $step = false)
    {
        $productsInCart = $this->getOrderData()['products'];

        if ($force == 1 || $productsInCart[$id] == 0) {
            unset($productsInCart[$id]);
        } else {
            $productsInCart[$id] -= $step;

        }

        $_SESSION['order']['products'] = $productsInCart;

        return true;
    }

    /**
     * @return int
     */
    public function getTotalProductsCount()
    {
        $sessionProducts = $this->getOrderData()['products'];

        if (!empty($sessionProducts)) {
            $count = 0;
            foreach ($sessionProducts as $id => $quantity) {
                $count = $count + $quantity;
            }

            return '2';
        } else {
            return 0;
        }
    }

    /**
     * Считает общую сумму по конкретному товару
     *
     * @param $id
     * @return mixed
     */
    public function getProdTotalPrice($id)
    {
        return $this->pricesRepository->getProductPrice($id)['price'] * $this->getOrderData()['products'][$id];
    }

    /**
     * @param $id
     * @return int
     */
    public function getItemsCount($id)
    {
        if (isset($this->getOrderData()['products'][$id])) {
            $count = $this->getOrderData()['products'][$id];

            return $count;
        } else {
            return 0;
        }
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $_SESSION['order']['delivery'] = $data['DeliveryTypeForm'];
        $_SESSION['order']['deliveryCity'] = $data['DeliveryCities'];
        $_SESSION['order']['personalData'] = $data['OrderForm'];
    }

    /**
     * @param $orderData
     * @return bool
     * @throws \yii\base\Exception
     */
    public function checkout($orderData)
    {

        $order = $this->loadOrder($orderData['OrderForm']);

        $idOrder = $this->orderRepository->saveOrderData($order);

        $orderProducts = $this->getOrderProducts();
        $sessionProducts = $this->getOrderData()['products'];

        foreach ($orderProducts as $item) {
            $orderProds = $this->loadJoinedProds($idOrder, $item->id, $sessionProducts[$item->id], $item->price);
            $this->orderRepository->saveJoinedProducts($orderProds);
        }
        $this->clearOrder($order->id);

        return true;
    }

    /**
     * @param $orderData
     * @return Order
     */
    private function loadOrder($orderData)
    {

        $order = new Order;
        $order->total_sum = $this->getTotalSum();
        $order->sum_with_discount = $order->total_sum;
        $order->attributes = $orderData;

        if (\Yii::$app->user->id) {
            $order->id_user = \Yii::$app->user->id;
        }

        return $order;
    }

    /**
     * @param $idOrder
     * @param $id_prod
     * @param $quantity
     * @param $price
     * @return OrderJoinProd
     */
    private function loadJoinedProds($idOrder, $id_prod, $quantity, $price)
    {
        $orderProds = new OrderJoinProd;
        $orderProds->id_order = $idOrder;
        $orderProds->id_prod = $id_prod;
        $orderProds->quantity = $quantity;
        $orderProds->price = $price;

        return $orderProds;
    }

    /**
     * @param $id
     */
    private function clearOrder($id)
    {
        unset($_SESSION['order']);
        $_SESSION['order_id'] = $id;
    }
}