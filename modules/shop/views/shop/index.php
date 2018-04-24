<?php
use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\shop\components\widgets\ProductWidget\ProductWidget;

$model_cats = $cat;
while($model_cats){
    
    $model_cats = $model_cats->parCats;
    if($model_cats->id_par==0)break;
    if($model_cats)
    $this->title=$model_cats->name." | ".$this->title;
    
}

\app\assets\ShopAsset::register($this);
$this->title.= $cat->name." в Colormarket.online | купить ".$cat->name.", цена, отзывы, продажа";
$this->params['description'] = "Купить ".$cat->name." в интернет-магазине Colormarket (Колормаркет). Тел: +38 044 594 19 42, лучшие цены, доставка, гарантия!";
if ($cat->seo_title_ru != "") {
    $this->title = $cat->seo_title_ru;
}

$this->registerMetaTag(['content' => $cat->seo_description_ru, 'name' => 'description']);
$this->registerMetaTag(['content' => $cat->seo_keywords_ru, 'name' => 'keywords']);

$page = \Yii::$app->request->get('page');

/**
 * CASHE
 */
if ($this->beginCache('shop_full_product_card_'.$cat->id.$cat->id_par.\Yii::$app->params['currency_name'].($page?$page:0), ['duration' => 86400])){



$this->params['breadcrumbs'] = BreadcrumbsGen::getCatalogBreadcrumbs($cat);
?>

<div class="category-page">
    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    
    <div class="category-wrap container-big flex">
        <?= \app\modules\shop\components\widgets\MainCategoriesWidget\MainCategoriesWidget::widget(['view'=>'other'])?>
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
        <?= \app\modules\shop\components\widgets\FiltersWidget\FiltersWidget::widget(['cat'=>$cat])?>
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
        <div class="product-items">
            <?= ProductWidget::widget(['provider'=>$dataProvider,'maxPrice'=>$maxPrice]) ?>
            <input type="hidden" id="maxPrice" value="<?=$maxPrice?>" />
        </div>
    </div>
</div>
<?php
        $this->endCache();

}?>