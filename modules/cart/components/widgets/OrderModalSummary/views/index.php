<?php use app\modules\cart\helpers\OrderFormHelper;

if ($products): ?>
    <h1><?=Yii::t('trans', 'in_cart')?> <?= OrderFormHelper::getTotalQuantity(); ?> <?=Yii::t('trans', 'goods_cart')?></h1>
    <div class="basket-items">

    <?php foreach ($products as $product): ?>



        <div class="basket-item flex">
            <p class="bi-name"><?= $product->name;?></p>
            <div class="bi-bye flex">
                <div class="set-count">
                    <span data-add="true" data-type="modal" data-id="<?= $product->id; ?>" data-step="<?=$product->cats[0]->fractional?>" onclick="changeValue(this, true);" class="minus"></span>
                            <input data-type="modal" data-id="<?= $product->id; ?>" type="tel" onkeypress='return checkDot(this, event);'
                                value="<?= OrderFormHelper::getProductQuantity($product['id']); ?>" />
                        <span data-add="true" data-type="modal" data-id="<?= $product->id; ?>" data-step="<?=$product->cats[0]->fractional?>" onclick="changeValue(this, true);" class="plus"></span>
                </div>
                <div class="bi-price"><?= round($product->price*OrderFormHelper::getProductQuantity($product['id']),2); ?> <span><?=\Yii::$app->params['currency_name']?></span></div>
                <a class="delete-bi del checkout_del" data-id="<?= $product->id; ?>"  data-type="modal" href="javascript:void(0);"></a>
            </div>
        </div>

    <?php endforeach; ?>
    </div>
    <div class="summaty-price">
        <p><?=Yii::t('trans', 'summa')?> <?= $summary['totalSum']; ?> <span><?=\Yii::$app->params['currency_name']?></span></p>
    </div>
    <?php else:?>

    <h1><?=Yii::t('trans', 'in_cart')?> <?=Yii::t('trans', 'empty')?></h1>


    <?php
    if ($errors) {
        echo $errors;
    }
    ?>
<?php endif; ?>
