<?php

use yii\widgets\Breadcrumbs;

\app\assets\CartAsset::register($this);
$this->title = 'Оформление заказа';
$this->registerMetaTag(['content' => 'Оформление заказа', 'name' => 'description']);
$this->registerMetaTag(['content' => 'Оформление заказа', 'name' => 'keywords']);

$this->params['breadcrumbs'][] = 'Оформление заказа';

if (isset($order->payment_type) && $order->payment_type == 1) {
    require(__DIR__ . '/liqpay.php');
    $liqpay = new LiqPay('i70331547031', 'WA1tf2oY8LONy6MAXOKini63cQi0bfqZPbl8oiOo');
    $liqpay_code = $liqpay->cnb_form(array(
        'action' => 'pay',
        'amount' => $order->total_sum,
        'currency' => 'UAH',
        'description' => 'Заказ товара',
        'order_id' => $order->id,
        'version' => '3',
        'server_url'=> $_SERVER['HTTP_HOST'] . '/' . 'cart/pay',
//        'sandbox'=> 1
    ));
    $liqpay_code = str_replace('<input type="image"','<input type="submit" class="orange_button" value="Оплатить"',$liqpay_code);
}



?>
<?php if ($_SESSION['order_id']): ?>
    <div class="basket-page">
        <div class="container-big">
            <h2>Подтверждение заказа</h2>
            <div class="thx-page">
                <h2>Спасибо за покупку!</h2>
                <p>Ваш заказ № <?= $order_number ?> принят к исполнению.</p>
                <?php if(isset($order->payment_type) && $order->payment_type == 1):?>
                <p>Перенаправление на сервис онлайн оплаты произойдет через: <span id="redirect_time"></span></p><br/>
                <form method="POST" action="https://www.liqpay.ua/api/3/checkout" 
                      accept-charset="utf-8" id="pay-online">
                          <?= $liqpay_code ?>
                </form>
                <?php endif;?>
                <a href="<?= \Yii::$app->urlManager->createUrl('/'); ?>">На главную страницу</a>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['order_id']); ?>
<?php else: ?>
    <div class="basket-page">
        <div class="container-big">
            <h2>Корзина</h2>
            <div class="thx-page">
                <h2>Ваша корзина пуста</h2>
                <a href="<?= \Yii::$app->urlManager->createUrl('/'); ?>">На главную страницу</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($order->payment_type) && $order->payment_type == 1): ?>
    <script type="text/javascript">
        window.onload = function () {
            var timesec = 10000;
            var i = 0;
            var auto = setTimeout(function () {
                autoRefresh();
            }, 100);
            var mytimer = setTimeout(function () {
                timer();
            }, 1000);

            function timer() {
                i = i + 1;
                clearTimeout(mytimer);
                
                $("#redirect_time").html(Math.round((timesec - i * 1000) / 1000));
                mytimer = setTimeout(function () {
                    timer();
                }, 1000);
            }
            function submitform() {
                $("#pay-online").submit();
            }

            function autoRefresh() {
                clearTimeout(auto);
                auto = setTimeout(function () {
                    submitform();
                    autoRefresh();
                }, 10000);
            }
        }
    </script>
<?php endif; ?>
