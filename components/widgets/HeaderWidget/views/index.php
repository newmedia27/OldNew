<?php use app\models\SmapPages;
use app\modules\cart\helpers\OrderFormHelper;
use yii\helpers\Html;

?>
<header class="main-header">
    <div class="top-line">
        <div class="container flex">
            <button class="hamburger hamburger--squeeze" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
            <p class="head-phone"><?= Yii::t('trans', 'phone_1') ?></p>
            <div class="top-line-menu flex">
                
                <ul class="top-soc flex">
                    <li><a href="<?= Yii::t('trans', 'url_facebook_page') ?>"><img width="18" src="/img/main/facebook.svg"></a></li>
                    <li><a href="<?= Yii::t('trans', 'url_youtube_page') ?>"><img height="18" src="/img/main/youtube-logo.svg"></a></li>
                </ul>
                <div class="top-nav">
                    <?php foreach ($items as $item):?>
                        <span><?php echo Html::a($item->name, Yii::$app->urlManager->createUrl('/'.$item->alias)); ?></span>
                    <?php endforeach;?>
                </div>
<!--                --><?//=\app\components\widgets\LanguageSelector\LanguageSelectorWidget::widget()?>
                <?=\app\components\widgets\CurrencySelector\CurrencySelectorWidget::widget()?>
            </div>
            <a class="basket-sm" href="/cart">
                <img src="/img/header/basket-sm.png" alt="">
            </a>
        </div>
    </div>

    <div class="main-head">
        <div class="container flex">
            <div class="logo">
                <a href="/"><img src="/img/header/logo.svg" alt=""></a>
            </div>
            <div class="mh-components flex">
                <?= \app\components\widgets\SearchWidget\SearchWidget::widget()?>

                <?php if (Yii::$app->user->isGuest):?>
                    <div class="account-settings">
                        <a href="/login"><?= Yii::t('trans', 'sign_in') ?></a>
                    </div>
                <?php else:?>
                    <div class="account-settings">
                        <span><?=Yii::$app->user->identity->username?></span>
                        <a href="/profile/personal_data"><?=Yii::t('trans', 'preferences')?></a>
                    </div>
                <?php endif?>
                <div class="basket-wrap">
                    <a href="/cart"><?=Yii::t('trans', 'in_cart')?><br> <span class="cart_count-number"><?= OrderFormHelper::getTotalQuantity(); ?></span> <?=Yii::t('trans', 'goods_cart')?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-nav-wrap">
        <div class="container">
            <nav class="main-nav">
                 <ul class="first-level flex">
                    <?php $smap = new SmapPages();
                    $smap->getList(); ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
