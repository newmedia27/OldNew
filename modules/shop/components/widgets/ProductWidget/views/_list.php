<?php

use app\modules\shop\components\widgets\AttributesWidget\AttributesWidget;
use app\modules\shop\components\widgets\BuyWidget\BuyWidget;


$thumb = \app\models\CmsFilesThumb::find()->where(['id_file' => $model->file[0]->id, 'size' => 1])->one();
$prevprice = \app\models\CmsAttributesValues::find()->where(['id_attr' => '1', 'id_obj' => $model->id, 'type' => 'product'])->one();
?>

<?php foreach ($model->attrs as $attr): ?>
    <?php if ($attr->id == 2) {
        $string = 'pi-new';
    } elseif ($attr->id == 3) {
        $string = 'pi-sales';
    } elseif ($attr->id == 13) {
        $availible = Yii::t('trans', 'available_prod');
    } ?>
<?php endforeach; ?>

<div class="pi-item <?= $string ?>">
    <div class="pi-image">
        <a class="image-link" href="<?= \app\components\helpers\PathHelper::productPath($model) ?>"></a>
        <img src="<?= !empty($thumb->path) ? $thumb->path : ($model->file[0]->path_thumb ? $model->file[0]->path_thumb : $model->file[0]->path) ?>"
             alt="">
        <?= BuyWidget::widget(['id_prod' => $model->id]); ?>
    </div>
    <?= BuyWidget::widget(['id_prod' => $model->id, 'view' => 'desktop']); ?>
    <div class="pi-desc-wrap">
        <p class="pi-name"><a
                    href="<?= \app\components\helpers\PathHelper::productPath($model) ?>"><?= $model->name ?></a></p>


        <?php if ($model->quantity > 0): ?>
            <div class="pi-available"><?= Yii::t('trans', 'available_prod') ?>!</div>
        <?php else: ?>
            <div class="pi-unavailable"><?= Yii::t('trans', 'not_available_prod') ?>.</div>
        <?php endif; ?>
        <div class="clearfix"></div>
        <div class="pi-desc">
            <div class="pid-left">
                <?php if (isset($prevprice)): ?>
                    <p class="prev-price"><?= $prevprice->text . ' ' . Yii::t('trans', 'uah'); ?></p>
                <?php endif; ?>
                <div class="prod-count">
                    <span class="cur-price"><?= $model->price ?><span> <?= \Yii::$app->params['currency_name'] ?></span></span>
                    <div class="set-count">
                        <span data-id="<?= $model->id; ?>"

                              data-step="<?= $model->cats[0]->fractional ?>"
                              onclick="changeValue(this);" class="minus"></span>
                        <input id="<?= 'count_prods' . $model->id; ?>"
                               type="tel" <?= $model->cats[0]->fractional == 0 ? "onkeypress='return event.charCode >= 48 && event.charCode <= 57;'" : "onkeypress='return checkDot(this, event);'" ?>
                               value="1"/>
                        <span data-id="<?= $model->id; ?>"
                              data-step="<?= $model->cats[0]->fractional ?>"
                              onclick="changeValue(this);" class="plus"></span>
                    </div>
                </div>
                <?= BuyWidget::widget(['id_prod' => $model->id, 'view' => 'empty']); ?>
            </div>
            <div class="pid-right">
                <?= \app\modules\shop\components\widgets\ChracteristicsWidget\ChracteristicsWidget::widget(['prod' => $model, 'view' => 'catalog']) ?>
            </div>
        </div>
    </div>
</div>

