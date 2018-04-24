<?php
use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\blog\components\widgets\BlogCategoriesWidget\BlogCategoriesWidget;
use app\modules\coloring\components\widgets\ChracteristicsWidget\ChracteristicsWidget;
use app\modules\comments\components\widgets\CommentListWidget\CommentListWidget;

\app\assets\CartAsset::register($this);

$this->title = $prod->name;
$this->registerMetaTag(['content' => $prod->name, 'name' => 'description']);
$this->registerMetaTag(['content' => $prod->name, 'name' => 'keywords']);

$this->params['breadcrumbs'] = BreadcrumbsGen::getProductBreadcrumbs($prod);
$thumb = \app\models\CmsFilesThumb::find()->where(['id_file' => $prod->file[0]->id, 'size' => 1])->one();

?>
<!--blog entry-->
<div class="blog-wrap">

    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>

    <div class="container-big">
        <h1 class="hidden-on-xs"><?=$cat->name?></h1>
        <div class="blog-category-wrap hidden-on-xs">
            <?= ChracteristicsWidget::widget(['prod'=>$prod]) ?>
        </div>

        <div class="blog-content blog-entry-content">
            <div class="blog-items">
                <div class="blog-item">
                    <div class="clearfix"></div>
                    <!-- <div class="bi-img">
                        <img src="<?/*=$thumb->path?$thumb->path:$prod->file[0]->path*/?>" alt="">
                    </div> -->
                    <div class="bi-desc" style="font-size: 16px;">
                        <h4><?=$prod->name?></h4>
                        
                        <p><?= $prod->description ?></p>
                        <p><?= $prod->long_description ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="blog-repost">
                <h2>Поделиться:</h2>
                <?=\app\components\widgets\SocialBtnWidget\SocialBtnWidget::widget()?>
            </div>
            <div class="blog-repost">
                <?=\app\modules\coloring\components\widgets\OtherColoringWidget\OtherColoringWidget::widget(['prod'=>$prod])?>
            </div>
            <?php if (!Yii::$app->user->isGuest):?>
                <?= app\modules\comments\components\widgets\CommentFormWidget\CommentFormWidget::widget(['idObj' => $prod->id,'type' => 'coloring', 'idPar' => 0]); ?>
            <?php endif;?>
            <?= CommentListWidget::widget(['idObj' => $prod->id, 'type' => 'coloring', 'idPar' => 0]); ?>

        </div>
    </div>
</div>
<!--end blog-->