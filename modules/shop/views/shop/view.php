<?php

use app\components\BreadcrumbsGen;
use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\components\widgets\SocialBtnWidget\SocialBtnWidget;
use app\modules\comments\components\widgets\CommentListWidget\CommentListWidget;
use app\modules\shop\components\widgets\BuyWidget\BuyWidget;
use app\modules\shop\components\widgets\ProductPhotoWidget\ProductPhotoWidget;

\app\assets\ShopAsset::register($this);
\app\assets\ProdAsset::register($this);

$this->title = $prod->name;
if ($prod->seo_title_ru != "")
    $this->title = $prod->seo_title_ru;

$this->registerMetaTag(['content' => $prod->seo_description_ru, 'name' => 'description']);
$this->registerMetaTag(['content' => $prod->seo_keywords_ru, 'name' => 'keywords']);
$this->registerMetaTag(['property' => 'og:image', 'content' => Yii::$app->request->hostInfo . $photo->path]);

$this->params['breadcrumbs'] = BreadcrumbsGen::getProductBreadcrumbs($prod);


?>

<div class="product-page">
    <?= Breadcrumbs::widget(['items' => $this->params['breadcrumbs']]) ?>
    <div class="product container-big">
        <div class="category-wrap">
            <?= \app\modules\shop\components\widgets\MainCategoriesWidget\MainCategoriesWidget::widget(['view' => 'other']) ?>

        </div>
        <div class="product-self" itemscope itemtype="http://schema.org/Product">
            
            <meta itemprop="url" content="https://colormarket.online/<?=$prod->path?>">

            <div class="popup-gallery-wrap hidden-on-xs">
                <div class="popup-gallery">
                    <?= ProductPhotoWidget::widget(['id_obj' => $prod->id, 'type' => 'product', 'attr' => $prod->attrs[0]->id, 'name' => $prod->name]); ?>
                </div>
                <div class="repost-icons">
                    <?= SocialBtnWidget::widget() ?>
                </div>
                <?php if (isset($code_prod)): ?>
                    <p><?= $code_prod->cmsAttributesValues[0]->idAttr->name ?>
                        :<span><?= $code_prod->cmsAttributesValues[0]->text ?></span></p>
                <?php endif; ?>
                <p><?= Yii::t('trans', 'article') ?>:<span><?= $prod->article; ?></span></p>
                <p><a onclick="scrollToReviews(event);" href="#"><?= Yii::t('trans', 'comments_prod') ?>
                        (<?= $comments ?>)</a></p>
            </div>
            <div class="product-description" itemprop="description">
                <div class="pd-name" itemprop="name"><?= $prod->name ?></div>
                <?php if ($prod->quantity > 0): ?>

                    <div class="pi-available"><?= Yii::t('trans', 'available_prod') ?>!</div>
                <?php else: ?>
                    <div class="pi-unavailable"><?= Yii::t('trans', 'not_available_prod') ?>.</div>
                <?php endif; ?>

                <meta itemprop="availability" content="http://schema.org/<?=($prod->quantity > 0)?'InStock':'Discontinued'?>">

                <div class="gallery-xs hidden-on-lg owl-carousel">
                    <?= ProductPhotoWidget::widget(['id_obj' => $prod->id, 'type' => 'product', 'attr' => $prod->attrs[0]->id, 'name' => $prod->name]); ?>
                </div>

                <div class="pd-item">
                    <?php if (isset($prevprice->cmsAttributesValues[0]->text)): ?>
                        <p class="prev-price"><span><?= $prevprice->cmsAttributesValues[0]->text ?></span> <?= \Yii::$app->params['currency_name'] ?></p>
                    <?php endif; ?>
                    <div class="prod-count">


                        <span class="cur-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <meta itemprop="priceCurrency" content="UAH">
                            <span itemprop="price" content="<?= $prod->price ?>"><?= $prod->price ?></span>
                            <span><?= \Yii::$app->params['currency_name'] ?></span>
                        </span>

                        <div class="set-count">
                            <span data-id="<?= $prod->id; ?>" data-step="<?=$prod->cats[0]->fractional?>"
                                  onclick="changeValue(this);" class="minus"></span>
                            <input id="<?= 'count_prods' . $prod->id; ?>"
                                   type="tel" onkeypress='return checkDot(this, event);'
                                   value="1"/>
                            <span data-id="<?= $prod->id; ?>" data-step="<?=$prod->cats[0]->fractional?>"
                                  onclick="changeValue(this);" class="plus"></span>
                        </div>
                        <div class="clearfix hidden-on-lg"></div>
                        <?= BuyWidget::widget(['id_prod' => $prod->id, 'view' => 'buy_prod']); ?>

                    </div>
                </div>
                <div class="pd-item">
                    <h4><?= Yii::t('trans', 'characteristics_prod') ?>:</h4>
                    <?= \app\modules\shop\components\widgets\ChracteristicsWidget\ChracteristicsWidget::widget(['prod' => $prod]) ?>

                    <?php foreach ($prod->cats[0]->idTrees as $tree): ?>
                        <?php if ($tree->id == 2): ?>
                            <div class="calculator flex">
                                <a class="main-button" href="#"><span><?= $tree->name ?></span></a>
                                <a class="main-button"
                                   href="#"><span>Pасход = <?= $rashod->cmsAttributesValues[0]->text ?></span></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <?php if (isset($naznachenie)): ?>
                    <div class="pd-item for-what">
                        <h4><?= Yii::t('trans', 'naznachenie') ?>:</h4>
                        <?php ?>
                        <p class="char-desc"><span><?= $naznachenie->cmsAttributesValues[0]->text ?></span></p>
                    </div>
                <?php endif; ?>


            </div>

            <div class="soc-xs hidden-on-lg">
                <div class="repost-icons">
                    <?= SocialBtnWidget::widget() ?>
                </div>
                <p><?= $code_prod->cmsAttributesValues[0]->idAttr->name ?>
                    :<span><?= $code_prod->cmsAttributesValues[0]->text ?></span></p>
                <p><?= Yii::t('trans', 'article') ?>:<span><?= $prod->article; ?></span></p>
                <p><a onclick="scrollToReviews(event);" href="#"><?= Yii::t('trans', 'comments_prod') ?>
                        (<?= $comments ?>)</a></p>
            </div>

            <div class="detailed-description">
                
                <div class="dd-nav">
                    <?php if ($prod->description): ?>
                        <a data-desc="dd1" class="active" onclick="ddNavClick(this);" href="javascript:void(0);"><?= Yii::t('trans', 'description_prod') ?></a>
                    <?php endif; ?>
                    <?php if ($prod->long_description): ?>
                        <a data-desc="dd3" onclick="ddNavClick(this);" href="javascript:void(0);">Техническая документация</a>
                    <?php endif; ?>
                    <?php if ($video->cmsAttributesValues[0]->text): ?>
                        <a onclick="ddNavClick(this);" data-desc="dd2" href="javascript:void(0);">Видео обзор</a>
                    <?php endif; ?>
                </div>
                
                <?php if ($prod->description || $video->cmsAttributesValues[0]->text || $prod->long_description ): ?>
                    <div class="dd-body">
                        <?php if ($prod->description): ?>
                            <div class="dd1 dd-item active">
                                <p itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><?= $prod->description; ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($video->cmsAttributesValues[0]->text): ?>
                            <div class="dd2 dd-item" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                                <?= $video->cmsAttributesValues[0]->text ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($prod->long_description): ?>
                            <div class="dd3 dd-item" >
                                <p itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><?= $prod->long_description; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            </div>

            <?php if (!Yii::$app->user->isGuest): ?>
                <?= app\modules\comments\components\widgets\CommentFormWidget\CommentFormWidget::widget(['idObj' => $prod->id, 'type' => 'products', 'idPar' => 0]); ?>
            <?php endif; ?>
            <?= CommentListWidget::widget(['idObj' => $prod->id, 'type' => 'products', 'idPar' => 0]); ?>

            <div class="product-carousel-wrap">
                <h3><?= Yii::t('trans', 'you_ve_seen') ?></h3>
                <div class="product-carousel owl-disabled">
                    <?= \app\modules\shop\components\widgets\LastProductsWidget\LastProductsWidget::widget() ?>
                </div>
            </div>

        </div>

    </div>
</div>