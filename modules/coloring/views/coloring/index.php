<?php

use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\blog\components\widgets\BlogCategoriesWidget\BlogCategoriesWidget;
use app\modules\blog\components\widgets\BlogFiltersWidget\BlogFiltersWidget;
use app\modules\blog\components\widgets\BlogWidget\BlogWidget;
use app\modules\coloring\components\widgets\ColoringWidget\ColoringWidget;
use app\modules\coloring\components\widgets\TopFiltersWidget\TopFiltersWidget;

app\assets\CartAsset::register($this);
\app\assets\ShopAsset::register($this);
$this->title = $page->name;
if($page->name == '')
    $this->title = $page->name;
$this->registerMetaTag(['content' => $page->description,'name'=>'description']);

$this->params['breadcrumbs'][] = ['label' => $page->name];

$url_array = explode('/', Yii::$app->request->url);
?>
<!--blog-->
<div class="blog-wrap coloring-wrap">
    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    <div class="container-big">
        <h1><?=$page->name?></h1>
        <div class="cat-sort-wrap">
            <div class="cat-sort container-big flex">
                <?= \app\modules\coloring\components\widgets\TopFiltersWidget\TopFiltersWidget::widget(['view'=>'other'])?>
            </div>
        </div>
        <div class="cat-content container-big">
            <?= \app\modules\shop\components\widgets\FiltersWidget\FiltersWidget::widget(['cat'=>$page])?>

            <div class="cat-sort-wrap">
                <div class="cat-sort container-big flex">
                    <?= \app\modules\coloring\components\widgets\TopFiltersWidget\TopFiltersWidget::widget(['view'=>'other'])?>

                </div>
            </div>

            <div class="blog-content">
                <div class="blog-items product-items">
                    <?=ColoringWidget::widget(['dataProvider'=> $dataProvider])?>
                </div>
            </div>
        </div>

    </div>
</div>


