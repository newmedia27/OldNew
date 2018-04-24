<?php
use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\feedback\components\widgets\FeedbackWidget\FeedbackWidget;

$this->title = $model[0]->name;
$this->registerMetaTag(['content' => $this->title,'name'=>'description']);
$this->registerMetaTag(['content' => $this->title,'name'=>'keywords']);
\app\assets\ContactAsset::register($this);
$this->params['breadcrumbs'] = BreadcrumbsGen::getSmapBreadcrumbs($model[0]);
?>

<!--page contacts-->
<div class="page-about">
    <div class="breadcrumbs-wrap">
        <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    </div>

    <div class="pa-head pa-contact-head hidden-on-xs container">
        <h1><?=$model[0]->name?></h1>
    </div>

    <div class="pa-content-wrap container-big flex">

        <?=\app\components\widgets\SmapMenuWidget\SmapMenuWidget::widget(['id_class'=>7])?>

        <div class="pa-head pa-contact-head hidden-on-lg container">
            <h1><?=$model[0]->name?></h1>
        </div>

        <div class="pa-contacts">
            <?=$model[0]->smap_text?>

            <div class="contact-form">
                <h3><?= Yii::t('trans', 'contact_us')?>:</h3>
                <?= FeedbackWidget::widget(['view' => 'contacts'])?>
            </div>

        </div>
    </div>
</div>
<!--end page contacts-->
