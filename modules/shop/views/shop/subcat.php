<?php
use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\shop\components\widgets\ProductsViewsWidget\ProductsViewsWidget;
use app\modules\shop\components\widgets\ProductCatWidget\ProductCatWidget;
use app\modules\shop\components\widgets\ProductWidget\ProductWidget;
use yii\widgets\ListView;

\app\assets\ShopAsset::register($this);

$this->title = $cat->name;
if ($cat->seo_title_ru != "") {
    $this->title = $cat->seo_title_ru;
}

$this->registerMetaTag(['content' => $cat->seo_description_ru, 'name' => 'description']);
$this->registerMetaTag(['content' => $cat->seo_keywords_ru, 'name' => 'keywords']);

$this->params['breadcrumbs'] = BreadcrumbsGen::getCatalogBreadcrumbs($cat);
?>

<div class="category-page">
    <div class="breadcrumbs-wrap">
        <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    </div>
    <div class="category-wrap container-big flex">
        <?=\app\modules\shop\components\widgets\MainCategoriesWidget\MainCategoriesWidget::widget(['view'=>'other'])?>
    </div>
    <div class="container">
        <h2><?=$cat->name?></h2>
    </div>
    <div class="cat-sort-wrap">
        <div class="cat-sort container-big flex">
            <?= \app\modules\shop\components\widgets\TopFiltersWidget\TopFiltersWidget::widget(['view'=>'other'])?>
            <div class="sort-kind flex">
                <p>Вид</p>
                <a class="line-sort" data-sort="pi-blocks" href="#"><span></span></a>
                <a class="box-sort active" data-sort="pi-lines" href="#"><span></span></a>
            </div>
        </div>
    </div>

    <div class="cat-content container-big">

        <div class="cat-filter">
            <?= app\components\widgets\CategoriesWidget\CategoriesWidget::widget(['id_par' => $cat->id]) ?>
        </div>

        <div class="product-items">
            <?= ProductWidget::widget(['provider'=>$dataProvider,'maxPrice'=>$maxPrice]) ?>
        </div>
    </div>
</div>