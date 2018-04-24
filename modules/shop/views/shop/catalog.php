<?php

use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\shop\components\widgets\ProductsViewsWidget\ProductsViewsWidget;


\app\assets\ShopAsset::register($this);
$this->title = $cat->name;
if ($cat->seo_title != "") {
    $this->title = $cat->seo_title;
}

$this->registerMetaTag(['content' => $cat->seo_description_ru, 'name' => 'description']);
$this->registerMetaTag(['content' => $cat->seo_keywords_ru, 'name' => 'keywords']);

$this->params['breadcrumbs'][]['label'] = $cat->name;
?>


<!-- catalog -->
<div class="catalog-content">
    <div class="breadcrumbs-wrap">
        <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    </div>

    <div class="category-wrap container-big flex">
        <?= \app\modules\shop\components\widgets\MainCategoriesWidget\MainCategoriesWidget::widget()?>
    </div>

   <!--  <div class="cat-sort-wrap">
        <div class="cat-sort container-big flex">
            <?//= \app\modules\shop\components\widgets\TopFiltersWidget\TopFiltersWidget::widget() ?>
        </div>
    </div> -->

<!--    <div class="cat-sort-wrap">-->
<!--        <div class="cat-sort container-big flex">-->
<!--            --><?//= \app\modules\shop\components\widgets\TopFiltersWidget\TopFiltersWidget::widget(['view'=>'other'])?>
<!--        </div>-->
<!--    </div>-->

    <div class="product-items container-big">
        <div class="pi-wrap flex">
            <?= ProductsViewsWidget::widget(['view'=> 'new']) ?>
        </div>
         <div class="pi-wrap flex">
            <?= ProductsViewsWidget::widget(['view'=> 'sale']) ?>
        </div>
        <div class="pagination-wrap flex">
<!--            <a href="#" class="main-button"><span>Загрузить больше товаров</span></a>-->
<!--            <ul class="pagination">-->
<!--                <li><a class="active" href="#">1</a></li>-->
<!--                <li><a href="#">2</a></li>-->
<!--                <li><a href="#">3</a></li>-->
<!--                <li><a href="#">...</a></li>-->
<!--                <li><a href="#">8</a></li>-->
<!--                <li><a href="#">9</a></li>-->
<!--                <li><a href="#">10</a></li>-->
<!--            </ul>-->
        </div>
    </div>
</div>
<!-- end catalog -->
