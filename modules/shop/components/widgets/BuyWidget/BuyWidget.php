<?php

namespace app\modules\shop\components\widgets\BuyWidget;

use yii\base\Widget;
use yii\di\Container;

class BuyWidget extends Widget
{
    public $view = 'index';
    public $id_prod;
    public $orderService;

    public function init ()
    {
        $container = new Container();
        $this->orderService = $container->get('app\modules\cart\components\services\OrderService');
        parent::init();
    }

    public function run ()
    {
        return $this->render($this->view, [
            'id_prod' => $this->id_prod,
            'service' => $this->orderService
        ]);
    }
}
