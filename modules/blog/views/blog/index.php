<?php

use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\blog\components\widgets\BlogCategoriesWidget\BlogCategoriesWidget;
use app\modules\blog\components\widgets\BlogFiltersWidget\BlogFiltersWidget;
use app\modules\blog\components\widgets\BlogWidget\BlogWidget;

app\assets\CartAsset::register($this);
$this->title = $page->title;
if($page->title == '')
    $this->title = $page->name;
$this->registerMetaTag(['content' => $page->description,'name'=>'description']);


$this->params['breadcrumbs'][] = ['label' => $page->name, 'url' => ['/blog']];
if ($category){
    $this->params['breadcrumbs'][] = ['label' => $category->name];
}
$url_arrays = explode('?', Yii::$app->request->url);
$url_array = explode('/', $url_arrays[0]);
?>
<!--blog-->
<div class="blog-wrap">
    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    <div class="container-big">
        <h1><?=$page->name?></h1>
        <?= BlogFiltersWidget::widget(['queryParams' => $queryParams]); ?>

        <div class="blog-category-wrap">
            <h3><?=Yii::t('trans', 'category_zapis')?></h3>
            <div class="blog-category flex">
                <?= BlogCategoriesWidget::widget(['url' => $url_array]) ?>
            </div>
            <h3><?=Yii::t('trans', 'cloud_with_tags')?></h3>
            <div class="blog-category blog-tags">
                <?= \app\modules\blog\components\widgets\TagWidget\TagWidget::widget(['category'=>$category])?>
            </div>
        </div>

        <div class="blog-content">
            <div class="blog-items">
                <?php if (isset($tag)):?>
                    <h4><?=Yii::t('trans', 'related_posts')?> «<?=$tag->name_ru?>»</h4>
                <?php endif;?>
                <?= BlogWidget::widget(['provider' => $dataProvider]) ?>
            </div>
        </div>
    </div>
</div>


