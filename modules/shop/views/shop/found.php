<?php
/**
 * @link https://github.com/himiklab/yii2-search-component-v2
 * @copyright Copyright (c) 2014-2017 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */
/** @var yii\web\View $this */
/** @var ZendSearch\Lucene\Search\QueryHit[] $hits */
/** @var string $query */
/** @var yii\data\Pagination $pagination */
$query = yii\helpers\Html::encode($query);
$this->title = "Results for \"$query\"";
$this->params['breadcrumbs'] = ['Search', $this->title];

?>

<div class="search-results">
<div class="category-wrap container-big flex">
    <div class="category-page">
        <div class="container">
            <h2><?=Yii::t('trans', 'search_query')?> «<b><?=$query?></b>». <?=Yii::t('trans', 'found')?> <?=$count?> <?=Yii::t('trans', 'goods_cart')?></h2>
        </div>

        <div class="cat-content container-big">
            <div class="product-items">
                <div class="pi-wrap pi-lines">

                    <?php foreach ($hits as $hit): ?>
                        <div class="pi-item <?=$string?>">

                            <div class="pi-image">
                                <a class="image-link" href="<?=$hit->url?>"></a>
                                <?php if ($hit->img):?>
                                    <img src="<?= $hit->img ?>" alt="">
                                <?php else:?>
                                    <img src="/img/main/blog.jpg" alt="">
                                <?php endif;?>
                                <?=  \app\modules\shop\components\widgets\BuyWidget\BuyWidget::widget(['id_prod' => $hit->id]); ?>
                            </div>

                            <div class="pi-desc-wrap">
                                <p class="pi-name"><a href="<?=$hit->url?>"><?= $hit->title?></a></p>
                                <div class="clearfix"></div>
                                <div class="pi-desc">
                                    <div class="pid-left">
                                        <div class="pid_found">
                                            <div class="prod-count" style="margin-bottom: 20px;">
                                               <span class="cur-price"><?=round($hit->price*\Yii::$app->params['currency'],2)?><span> <?=\Yii::$app->params['currency_name']?></span></span>
                                           </div>
                                           <?= \app\modules\shop\components\widgets\BuyWidget\BuyWidget::widget(['id_prod' => $hit->id,'view'=>'desktop']); ?>
                                       </div>
                                       <p><?=(strlen($hit->body)>400?mb_substr( $hit->body,0,400).'...':$hit->body)?></p>     

                                   </div>
                               </div>
                           </div>

                       </div>
                   <?php endforeach;?>

               </div>
           </div>
       </div>
   </div>
</div>
</div>

<style type="text/css">
    .pid_found .prod-count, .pid_found a {
        display: inline-block;
        vertical-align: top;
    }
    .pid_found .cur-price {
        height: 40px;
        line-height: 40px;
    }
    .pid_found .prod-count {
        margin-right: 20px;
    }
</style>

<div class="pagination-wrap">
    <?=""; //yii\widgets\LinkPager::widget([
        //'pagination' => $pagination,
      // ]);?>
</div>