<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\components\widgets\FooterWidget\FooterWidget;
use app\components\widgets\HeaderWidget\HeaderWidget;
use app\models\SmapPages;
use app\modules\cart\components\widgets\OrderSummary\OrderSummary;
use app\modules\cart\helpers\OrderFormHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= HeaderWidget::widget() ?>

    <?= $content ?>
    <div id="popup_basket" class="popup-basket-wrap mfp-hide white-popup-block">
        <div class="orderSummary"></div>

        <div class="basket-buttons flex">
            <a class="go-to-bye" onclick="$.magnificPopup.close();" href="javascript:void(0);"><?=Yii::t('trans', 'dont_stop_buy')?></a>
            <a class="main-button" href="/cart"><?=Yii::t('trans', 'go_to_cart')?></a>
        </div>
    </div>
    <?= FooterWidget::widget() ?>

</div>

<nav id="mobile_menu">
    <ul>
        <?=\app\components\widgets\LanguageSelector\LanguageSelectorWidget::widget(['view'=>'mobile'])?>
        <?php $smap = new SmapPages();
        $smap->getMobileList(); ?>
        <li class="mmenu-soc">
            <a href="#"><span></span></a>
            <a href="#"><span></span></a>
            <a href="#"><span></span></a>
        </li>
    </ul>
</nav>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
