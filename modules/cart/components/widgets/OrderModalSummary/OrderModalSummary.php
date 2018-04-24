<?php

namespace app\modules\cart\components\widgets\OrderModalSummary;

use yii\base\Widget;
use yii\di\Container;

/**
 * Class OrderModalSummary
 * @package app\modules\cart\components\widgets\OrderModalSummary
 */
class OrderModalSummary extends Widget
{
    /**
     * @var
     */
    public $orderData;

    /**
     * @var \app\modules\cart\components\services\OrderService
     */
    protected $orderService;


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init ()
    {
        parent::init();

        $container = new Container;
        $this->orderService = $container->get('\app\modules\cart\components\services\OrderService');
    }

    /**
     * @return string
     */
    public function run ()
    {
        return $this->render('index', [
            'summary' => $this->orderService->getOrderSummary(),
            'products' => $this->orderService->getOrderProducts(),
            'productsInCart' => $this->orderData['products']
        ]);
    }

    /**
     * @param $errText
     * @return string
     */
    protected function generateErrors ($errText)
    {
        if (!empty($errText)) {
            $html = '';
            foreach ($errText as $item) {
                $html .= "<span>$item</span><br>";
            }

            return $html;
        }
    }
}