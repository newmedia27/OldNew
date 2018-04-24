<?php
/* @var $this yii\web\View */

$this->title = 'Colormarket (Колормаркет) - Интернет-магазин материалов для окраски всех типов поверхностей, колормаркет, colormarket, Европроект';
$this->params['description'] = 'Интернет-магазин в котором вы сможете подобрать товар по направениям: архитектура и декор, деревообработка, кузовной авторемонт, промышленная окраска металла, окрасочное оборудование и инструмент. Колормаркет, европроект';
?>
<!-- main page -->
<div class="owl-carousel-wrap">
    <div id="main_carousel" class="owl-carousel main-carousel">
        <?= app\components\widgets\BannersWidget\BannersWidget::widget(['id_pos' => '1']); ?>
    </div>
</div>
<div class="main-content">
    <div class="head-content container-big flex">
        <?= \app\components\widgets\PagesOnMainWidget\PagesOnMainWidget::widget(['id_class' => 8, 'id_par'=>62])?>
    </div>
    <div class="product-items container-big">
        <h2><?=Yii::t('trans', 'action_sale')?></h2>
        <div class="pi-wrap flex">
            <?= \app\modules\shop\components\widgets\ProductsViewsWidget\ProductsViewsWidget::widget(['view'=>'sale'])?>
        </div>
    </div>
    <div class="product-items container-big">
        <h2><?=Yii::t('trans', 'action_new')?></h2>
        <div class="pi-wrap flex">
            <?= \app\modules\shop\components\widgets\ProductsViewsWidget\ProductsViewsWidget::widget(['view'=>'new'])?>
        </div>
    </div>
    <div class="capabilities container-big">
        <h2><?=Yii::t('trans', 'more_with_colormaket')?></h2>
        <div class="cap-items flex">
            <?= \app\components\widgets\PagesOnMainWidget\PagesOnMainWidget::widget(['id_class' => 8, 'id_par'=>61])?>
        </div>
    </div>
</div>