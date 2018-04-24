<?php
use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;


$this->title = $model[0]->name;
$this->registerMetaTag(['content' => $this->title,'name'=>'description']);
$this->registerMetaTag(['content' => $this->title,'name'=>'keywords']);

$this->params['breadcrumbs'] = BreadcrumbsGen::getSmapBreadcrumbs($model[0]);

?>

<div class="page-about">
    <div class="breadcrumbs-wrap">
        <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    </div>

    <div class="pa-head container hidden-on-xs">
        <h1><?=$model[0]->name?></h1>
    </div>

    <div class="pa-head container hidden-on-lg">
        <h1><?=$model[0]->name?></h1>
    </div>

    <div class="pa-content-wrap container-big flex">
        <?php if($model[0]->alias=='training-center' || $model[0]->id_class==7)echo \app\components\widgets\SmapMenuWidget\SmapMenuWidget::widget(['id_class'=>7])?>
        <div class="smap_block"><?= $model[0]->smap_text ?></div>
    </div>
</div>