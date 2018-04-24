<?php
use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\blog\components\widgets\BlogCategoriesWidget\BlogCategoriesWidget;
use app\modules\comments\components\widgets\CommentListWidget\CommentListWidget;

\app\assets\CartAsset::register($this);

$this->title = $model[0]->name;
$this->registerMetaTag(['content' => $model[0]->name, 'name' => 'description']);
$this->registerMetaTag(['content' => $model[0]->name, 'name' => 'keywords']);

$this->params['breadcrumbs'] = BreadcrumbsGen::getNewsBreadcrumbs($model[0]);
$url_array = explode('/', Yii::$app->request->url);
?>
<!--blog entry-->
<div class="blog-wrap">

    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>

    <div class="container-big">
        <h1 class="hidden-on-xs"><?=$page->name?></h1>
        <div class="blog-category-wrap hidden-on-xs">
            <h3><?=Yii::t('trans', 'category_zapis')?></h3>
            <div class="blog-category flex">
                <?= BlogCategoriesWidget::widget(['url' => $url_array]) ?>
            </div>
            <h3><?=Yii::t('trans', 'cloud_with_tags')?></h3>
            <div class="blog-category blog-tags">
                <?= \app\modules\blog\components\widgets\TagWidget\TagWidget::widget(['category'=>$model[0]->categories[0]])?>
            </div>
        </div>

        <div class="blog-content blog-entry-content">
            <div class="blog-items">
                <div class="blog-item">
                    <div class="clearfix"></div>
                    <div class="bi-img">
                        <?php if ($model[0]['cmsFiles'][0]):?>
                            <img src="<?=$model[0]['cmsFiles'][0]->path?>" alt="">
                        <?php else:?>
                            <img src="/img/main/blog.jpg" alt="">
                        <?php endif;?>
                    </div>
                    <div class="bi-desc">
                        <h4><?= $model[0]->title?></h4>
                        <span><?=app\components\helpers\DateHelper::convertDate($model[0]->news_date_start, 'long')?></span>
                        <p><?= $model[0]->description_long ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="blog-repost">
                <h2>Поделиться:</h2>
                <?=\app\components\widgets\SocialBtnWidget\SocialBtnWidget::widget()?>
            </div>
            <div class="cloud-tag">
                <h2><?=Yii::t('trans', 'cloud_with_tags')?>:</h2>

                <div class="blog-category blog-tags">
                    <?= \app\modules\blog\components\widgets\TagViewWidget\TagViewWidget::widget(['model'=>$model[0]])?>
                </div>
            </div>
            <?php if (!Yii::$app->user->isGuest):?>
                <?= app\modules\comments\components\widgets\CommentFormWidget\CommentFormWidget::widget(['idObj' => $model[0]->id,'type' => 'news', 'idPar' => 0]); ?>
            <?php endif;?>
            <?= CommentListWidget::widget(['idObj' => $model[0]->id, 'type' => 'news', 'idPar' => 0]); ?>

        </div>
    </div>
</div>
<!--end blog-->