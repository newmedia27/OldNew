<?php use app\modules\cart\helpers\OrderFormHelper;
use app\models\CmsFiles;

if ($products): ?>


<ul class="bp-head">
    <li><?=Yii::t('trans', 'goods')?></li>
    <li><?=Yii::t('trans', 'cost_unit')?></li>
    <li><?=Yii::t('trans', 'units')?></li>
    <li><?=Yii::t('trans', 'price')?></li>
</ul>

<div class="bp-body">
    <div class="bp-items">
        <?php foreach ($products as $product): ?>
            <div class="bp-item flex">
                <div class="bpi-image">
                    <?php
                    $photos = CmsFiles::find()->where(['id_obj' => $product->id, 'type' => 'product'])
                        ->orderBy('onmain DESC')->all();

                    $code_prod = $cmsAttributesRepository->findAttributesWithValuesByParams(11, $product->id, 1, 'product');
                    ?>
                    <img src="<?=$photos[0]->path?>" alt="<?= yii\helpers\Html::encode( $product->name)?>">
                </div>
                <div class="bpi-desc">
                    <h5><?= $product->name; ?></h5>
                    <?php if (isset($code_prod)):?>
                        <p><?= $code_prod->cmsAttributesValues[0]->idAttr->name?>: <span><?= $code_prod->cmsAttributesValues[0]->text?></span></p>
                    <?php endif;?>
                    <p class="prod-art"><?=Yii::t('trans', 'article')?>: <?= $product->article; ?></p>
                </div>
                <p class="bpi-price bpi-one-price"><span><?=Yii::t('trans', 'cost_unit')?></span><?= $product->price; ?> <i><?=\Yii::$app->params['currency_name']?></i></p>
                <div class="set-count-wrap">
                    <span class="cound-sm"><?=Yii::t('trans', 'number')?></span>
                    <div class="set-count">
                        <span data-step="<?=$product->cats[0]->fractional?>" onclick="changeValue(this, true);" data-id="<?= $product->id; ?>" data-add="true" data-type="cart" class="minus"></span>
                        <input data-type="cart" data-id="<?= $product->id; ?>" type="tel" maxlength="3" onkeypress="return checkDot(this, event);" value="<?= OrderFormHelper::getProductQuantity($product['id']); ?>">
                        <span data-step="<?=$product->cats[0]->fractional?>" onclick="changeValue(this, true);" data-id="<?= $product->id; ?>" data-add="true" data-type="cart" class="plus"></span>
                    </div>
                </div>
                <p class="bpi-price bpi-price-summary"><span><?=Yii::t('trans', 'price')?></span><?= round($product->price*OrderFormHelper::getProductQuantity($product['id']),2); ?><i><?=\Yii::$app->params['currency_name']?></i></p>
                <a class="delete-bi del checkout_del" data-id="<?= $product->id; ?>" data-type="cart" href="javascript:void(0);"></a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="clear-cart">
        <a onclick="clean();" href="#">Очистить корзину</a>
    </div>

    <p class="summary-price"><?=Yii::t('trans', 'summa')?> <?= $summary['totalSum']; ?> <span><?=\Yii::$app->params['currency_name']?></span></p>

</div>
    <?php
    if ($errors) {
        echo $errors;
    }
    ?>
<?php else: ?>
    <div class="bp-table">
        <div class="cart-buttons-wrap">
            <div class="cart-buttons flex">
                <a class="continue-to-bye" href="<?= \Yii::$app->urlManager->createUrl('/catalog'); ?>"><?=Yii::t('trans', 'dont_stop_buy')?></a>
            </div>
        </div>
    </div>
<?php endif; ?>