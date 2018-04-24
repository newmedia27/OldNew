<?php

namespace app\modules\cart\components\widgets\OrderSummary;

use yii\base\Widget;
use yii\di\Container;

/**
 * Class OrderSummary
 * @package app\modules\cart\components\widgets\OrderSummary
 */
class OrderSummary extends Widget
{
    /**
     * @var
     */
    public $view = 'index';
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

        return $this->render($this->view, [
            'cmsAttributesRepository' => new \app\components\repositories\CmsAttributesRepository(),
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