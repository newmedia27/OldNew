<?php
use yii\helpers\Html;
?>

<div class="currency-selector">
    <a title="Гривна" class="<?=($_SESSION['currency']=='UAH'?'active':'')?>" href="<?=(preg_match('/\?/',Yii::$app->request->url)?Yii::$app->request->url.'&':'?')?>currency=UAH">&#8372; грн</a>
    <a title="Евро" class="<?=($_SESSION['currency']=='EUR'?'active':'')?>" href="<?=(preg_match('/\?/',Yii::$app->request->url)?Yii::$app->request->url.'&':'?')?>currency=EUR">&euro; eur</a>
</div>
