<?php
use app\modules\shop\components\widgets\BuyWidget\BuyWidget;
?>

<?php foreach ($provider as $model):?>
<?php $thumb = \app\models\CmsFilesThumb::find()->where(['id_file' => $model->file[0]->id, 'size' => 1])->one();
    $prevprice = \app\models\CmsAttributesValues::find()->where(['id_attr'=>'1','id_obj'=>$model->id, 'type'=>'product'])->one();

?>

    <?php foreach ($model->attrs as $attr):?>
        <?php if ($attr->id == 2){$string = 'pi-new';}
        elseif ($attr->id == 3){$string = 'pi-sales';}?>
    <?php endforeach;?>

    <style>
        .pi-lines .image-link {
            display: block;
        }
    </style>

<div class="pi-item <?=$string?>">
    <div class="pi-image">
        <a href="<?=\app\components\helpers\PathHelper::productPath($model)?>"></a>
        <img src="<?=$model->file[0]->path?>" alt="">
        <?= BuyWidget::widget(['id_prod' => $model->id]); ?>
    </div>
    <?= BuyWidget::widget(['id_prod' => $model->id,'view'=>'empty']); ?>
    <p class="pi-name"><a href="<?=\app\components\helpers\PathHelper::productPath($model)?>"><?= $model->name?></a></p>
    <?php if (isset($prevprice)):?>
    <p class="prev-price"><?= $prevprice->text . ' '. \Yii::$app->params['currency_name']; ?></p>
    <?php endif;?>
    <span class="cur-price"><?= $model->price . ' '. \Yii::$app->params['currency_name']; ?></span>
</div>

<?php endforeach;?>
