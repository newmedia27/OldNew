<?php
use app\modules\shop\components\widgets\ProductWidget\ProductWidget;
        
$query = yii\helpers\Html::encode($query);
$this->title = 'Результат для: "'.\Yii::$app->request->get('q').'"';
$this->params['breadcrumbs'] = ['Search', $this->title];

?>

    <div class="category-wrap container-big flex">
        <div class="category-page">
            <div class="container">
                <h2><?=Yii::t('trans', 'search_query')?> «<b><?= \Yii::$app->request->get('q')?></b>». <?=Yii::t('trans', 'found')?> <?=$count?> <?=Yii::t('trans', 'goods_cart')?></h2>
            </div>


        </div>
    </div>

    <div class="cat-content container-big">
        <div class="product-items" style="width: 100%;">
           <?= ProductWidget::widget(['provider'=>$dataProvider]) ?>
       </div>
   </div>

