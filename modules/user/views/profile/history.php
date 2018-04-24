<?php
use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\user\components\widgets\CabinetMenuWidget\CabinetMenuWidget;


$this->title = $page->name;
$this->registerMetaTag(['content' => $this->title,'name'=>'description']);
$this->registerMetaTag(['content' => $this->title,'name'=>'keywords']);

$this->params['breadcrumbs'] = BreadcrumbsGen::getCabinetBreadcrumbs($page);
\app\assets\UserAsset::register($this);
?>

<div class="my-account-wrap">
    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>

    <div class="container-big">
        <h2><?=$page->name?></h2>

        <div class="history-wrap">
            <div class="my-acc-nav">
                <?= CabinetMenuWidget::widget()?>
            </div>

            <div class="history-content">
                <?php if (count($orders)>0):?>
                <?=\app\modules\cart\components\widgets\OrderWidget\OrderWidget::widget(['orders'=> $orders])?>
                <?php else:?>
                    <h3><?=Yii::t('trans', 'empty')?></h3>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

