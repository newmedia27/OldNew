<?php
use app\modules\shop\components\helpers\FiltersHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="subcat-filter filter-refresh_ajax">
    <h4><span><?=Yii::t('trans', 'filters_search')?></span></h4>

    <?php if (isset($attributes)):?>
        <?php $form = ActiveForm::begin(['id' => 'form-filter']); ?>
            <?php foreach ($attributes as $attr):?>
                <div class="filter-refresh_attr">
                    <?= \app\modules\shop\components\widgets\FiltersViewsWidget\FiltersViewsWidget::widget(['attr'=>$attr,'form'=>$form])?>
                </div>
            <?php endforeach;?>
        <?php ActiveForm::end(); ?>
    <?php endif;?>
</div>
