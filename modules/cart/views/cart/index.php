<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\cart\components\widgets\OrderSummary\OrderSummary;

\app\assets\CartAsset::register($this);

$this->title = 'Корзина';
$this->registerMetaTag(['content' => 'Корзина', 'name' => 'description']);
$this->registerMetaTag(['content' => 'Корзина', 'name' => 'keywords']);

$this->params['breadcrumbs'][] = 'Корзина';
?>

<?php if ($order['products']): ?>

    <div class="basket-page">
        <div class="container-big">
            <h1>Корзина</h1>
            <div class="bp-items">

                <div class="bp-table orderSummary">
                    <?= OrderSummary::widget(['orderData' => $order]) ?>
                </div>
                <div class="bp-table">
                    <div class="cart-buttons-wrap">
                        <div class="cart-buttons flex">
                            <a class="continue-to-bye"
                               href="<?= \Yii::$app->urlManager->createUrl('/catalog'); ?>"><?= Yii::t('trans', 'dont_stop_buy') ?></a>
                            <a class="main-button"
                               href="<?= \Yii::$app->urlManager->createUrl('/checkout'); ?>"><?= Yii::t('trans', 'go_to_cart') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="basket-page">
        <div class="container-big">
            <h1>Корзина</h1>
            <div class="bp-items">
                <div class="bp-table">
                    Ваша корзина пуста
                </div>
                <div class="bp-table">
                    <div class="cart-buttons-wrap">
                        <div class="cart-buttons flex">
                            <a class="continue-to-bye"
                               href="<?= \Yii::$app->urlManager->createUrl('/catalog'); ?>"><?= Yii::t('trans', 'dont_stop_buy') ?></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
