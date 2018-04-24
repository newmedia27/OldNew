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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?= Yii::$app->language ?>">
<head>
     <meta charset="utf-8"/>
      <title><?= Html::encode($this->title) ?></title>
      <meta name="description" content="<?= Html::encode($this->params['description']) ?>" />

      <meta http-equiv="cache-control" content="max-age=3600, must-revalidate"/>
      <meta http-equiv="expires" content="<?= gmdate('D, d M Y H:i:s \G\M\T', time() + 3600) ?>"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115621369-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-115621369-1');
</script>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="google-site-verification" content="e4d3rK0ZfUEmbxoi_5WFZksr6S_m72hhg4Ows7Zgpxc" />
    <link rel="icon" href="/web/img/favicon/16x16.png" type="image/x-icon">
    <link rel="shortcut icon" href="/web/img/favicon/16x16.png" type="image/x-icon">
    

    <?= Html::csrfMetaTags() ?>
   
    $this->description
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
