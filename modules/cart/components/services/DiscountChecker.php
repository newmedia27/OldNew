<?php

namespace app\modules\cart\components\services;

use app\modules\shop\components\repositories\ShopProductsRepository;
use app\modules\cart\components\repository\OrderRepository;
use app\modules\cart\components\services\BaseOrder;
use yii\helpers\ArrayHelper;

/**
 * Class DiscountChecker
 * @package app\modules\cart\components\services
 */
class DiscountChecker extends BaseOrder
{
    /**
     * @var int
     */
    protected $discount = 0;

    /**
     * @var array
     */
    protected $err_text = [];

    /**
     * @var int
     */
    protected $all_orders_sum = 0;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ShopProductsRepository
     */
    protected $productsRepository;

    /**
     * DiscountChecker constructor.
     * @param OrderRepository $orderRepository
     * @param ShopProductsRepository $shopProductsRepository
     */
    public function __construct (OrderRepository $orderRepository,
                                 ShopProductsRepository $shopProductsRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->productsRepository = $shopProductsRepository;
    }

    /**
     * @return int
     */
    public function getSumWithDiscount ()
    {
        $products = $this->getOrderProducts();
        $sessionProducts = $this->getOrderData()['products'];

        $discount = $this->getAggregateDiscount()['discount'];
        $promoProducts = $this->productsRepository->findWithAttributes(3);

        $total = 0;

        foreach ($products as $product) {
            if (!$this->checkIfPromotional($product->id, $promoProducts) && $discount > 0) {
                $total += ($product->prices[0]->price - ($product->prices[0]->price * $discount / 100)) * $sessionProducts[$product->id];
            } else {
                $total += $product->prices[0]->price * $sessionProducts[$product->id];
            }
        }

        return $total;
    }

    /**
     * @return array
     */
    public function getAggregateDiscount ()
    {
        $coupon = $this->getOrderData()['coupon'];
        $sum = $this->getTotalSum();

        $this->checkFundedDiscount($sum);

        if ($coupon) {
            $this->checkCouponDiscount($coupon, $sum);
        }

        return ['discount' => $this->discount, 'errText' => $this->err_text];
    }

    /**
     *
     */
    private function checkFundedDiscount ()
    {
        if (!\Yii::$app->user->isGuest) {
            $orders_history = $this->orderRepository->getUserOrdersSum(\Yii::$app->user->id);

            if ($orders_history) {
                $this->all_orders_sum += $orders_history;
            }

            $this->all_orders_sum += $this->order_sum;

            if (\Yii::$app->user->id) {
                $this->discount = 5;
            }

            if ($this->all_orders_sum >= 3000) {
                $this->discount = 7;
            }

            if ($this->all_orders_sum >= 5000) {
                $this->discount = 10;
            }
        }

    }

    /**
     * @param $coupon
     * @param $sum
     */
    private function checkCouponDiscount ($coupon, $sum)
    {
        if ($coupon == 'Tiny5M3xG') {
            $this->discount = 15;
        } elseif ($coupon == 'tin5k') {
            if ($sum >= 1500) {
                $this->discount = 20;
            } else {
                unset($_SESSION['order']['coupon']);
                array_push($this->err_text, 'Купон действителен при сумме заказа от 1500 <?=\Yii::$app->params['currency_name']?>');
            }
        } elseif ($coupon == 'Lx056Msn') {
            $this->discount = 20;
        } else {
            unset($_SESSION['order']['coupon']);
            array_push($this->err_text, 'Купон недействителен');
        }
    }

    /**
     * @param $productId
     * @param $promoProducts
     * @return bool
     */
    private function checkIfPromotional ($productId, $promoProducts)
    {
        if (in_array($productId, ArrayHelper::getColumn($promoProducts, 'id'))) {
            return true;
        }

        return false;
    }

}