<?php

namespace app\modules\cart\components\widgets\OrderWidget;

use yii\base\Widget;
use yii\di\Container;

/**
 * Class OrderWidget
 * @package app\modules\cart\components\widgets\OrderWidget
 */
class OrderWidget extends Widget
{
    public $orders;

    /**
     * @return string
     */
    public function run ()
    {
        foreach ($this->orders as $order){
            if ($order->status == '333'){
                $new [] = $order;
            } elseif ($order->status == '888'){
                $old[] = $order;
            }elseif ($order->status == '0'){
                $not[] = $order;
            }
        }
        return $this->render('index', [
            'cmsAttributesRepository' => new \app\components\repositories\CmsAttributesRepository(),
            'new' => $new,
            'not' => $not,
            'old' => $old
        ]);
    }

}