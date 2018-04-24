<?php use app\models\CmsFiles;?>

<h3>Заказы в статусе "Новые"</h3>
<?php foreach ($not as $order):?>
    <div class="his-table">
        <div class="his-head flex">
            <div class="his-info flex">
                <p>Заказ №<?= $order->id?></p>
                <span><?= $order->date?></span>
            </div>
            <div class="his-status flex">
                <span class="his-new"><?=Yii::t('trans', 'new_zak')?></span>
                <a onclick="detOrder(this, event);" data-hidden="0" href="javascript:void(0);">Скрыть</a>
            </div>
        </div>

        <div class="his-body active">
            <div class="his-items">
                <?php foreach ($order->orderProds as $product): ?>
                    <?php
                    $code_prod = $cmsAttributesRepository->findAttributesWithValuesByParams(11, $product->id, 1, 'product');
                    $photos = CmsFiles::find()->where(['id_obj' => $product->id, 'type' => 'product'])
                        ->orderBy('onmain DESC')->all();
                    ?>
                    <div class="his-item flex">
                        <div class="his-image">
                            <img src="<?=$photos[0]->path?>" alt="">
                        </div>
                        <div class="his-desc">
                            <h5><?= $product->idProd->name; ?></h5>
                            <?php if (isset($code_prod)):?>
                                <p><?= $code_prod->cmsAttributesValues[0]->idAttr->name?>: <span><?= $code_prod->cmsAttributesValues[0]->text?></span></p>
                            <?php endif;?>
                            <p><?=Yii::t('trans', 'article')?>: <?= $product->idProd->article; ?></p>
                        </div>
                        <div class="his-count-price flex">
                            <p class="his-count"><?= $product->quantity ?> шт</p>
                            <p class="his-price"><?= $product->price * $product->quantity?> <?=\Yii::$app->params['currency_name']?></p>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="his-payment flex">
                <p>Способ оплаты: <?= $order->payment->name?></p>
                <p>Общая сумма заказа: <?= $order->total_sum?> <?=\Yii::$app->params['currency_name']?></p>
            </div>
            <div class="his-buttons">
                <a href="javascript:void()" data-id="<?=$order->id?>" class="repeat">Повторить заказ</a>
                <a href="javascript:void()" data-id="<?=$order->id?>" class="cancel">Отменить заказ</a>
            </div>
        </div>
    </div>

<?php endforeach;?>

<h3>Заказы в статусе "Принятые"</h3>
<?php foreach ($new as $order):?>
<div class="his-table">
    <div class="his-head flex">
        <div class="his-info flex">
            <p>Заказ №<?= $order->id?></p>
            <span><?= $order->date?></span>
        </div>
        <div class="his-status flex">
            <span class="his-active"><?=Yii::t('trans', 'prin_zak')?></span>
            <a onclick="detOrder(this, event);" data-hidden="0" href="javascript:void(0);">Скрыть</a>
        </div>
    </div>

    <div class="his-body active">
        <div class="his-items">
            <?php foreach ($order->orderProds as $product): ?>
                <?php

                $photos = CmsFiles::find()->where(['id_obj' => $product->id, 'type' => 'product'])
                    ->orderBy('onmain DESC')->all();
                $code_prod = $cmsAttributesRepository->findAttributesWithValuesByParams(11, $product->id, 1, 'product');

                ?>
                <div class="his-item flex">
                    <div class="his-image">
                        <img src="<?=$photos[0]->path?>" alt="">
                    </div>
                    <div class="his-desc">
                        <h5><?= $product->idProd->name; ?></h5>
                        <?php if (isset($code_prod)):?>
                            <p><?= $code_prod->cmsAttributesValues[0]->idAttr->name?>: <span><?= $code_prod->cmsAttributesValues[0]->text?></span></p>
                        <?php endif;?>
                        <p><?=Yii::t('trans', 'article')?>: <?= $product->idProd->article; ?></p>
                    </div>
                    <div class="his-count-price flex">
                        <p class="his-count"><?= $product->quantity ?> шт</p>
                        <p class="his-price"><?= $product->price * $product->quantity?> <?=\Yii::$app->params['currency_name']?></p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <div class="his-payment flex">
            <p>Способ оплаты: <?= $order->payment->name?></p>
            <p>Общая сумма заказа: <?= $order->total_sum?> <?=\Yii::$app->params['currency_name']?></p>
        </div>
        <div class="his-buttons">
            <a href="javascript:void()" data-id="<?=$order->id?>" class="repeat">Повторить заказ</a>
            <a href="javascript:void()" data-id="<?=$order->id?>" class="cancel">Отменить заказ</a>
        </div>
    </div>
</div>

<?php endforeach;?>

<div class="his-ready-head">
    <h3>Заказы в статусе "Оплачен"</h3>
</div>
<?php foreach ($old as $order):?>
<div class="his-table">
    <div class="his-head flex">
        <div class="his-info flex">
            <p>Заказ №<?= $order->id?></p>
            <span><?= $order->date?></span>
        </div>
        <div class="his-status flex">
            <span class="his-ready"><?=Yii::t('trans', 'paid_zak')?></span>
            <a onclick="detOrder(this, event);" data-hidden="1" href="javascript:void(0);"><?=Yii::t('trans', 'more_details')?></a>
        </div>
    </div>

    <div class="his-body">
        <div class="his-items">
            <?php foreach ($order->orderProds as $product): ?>
                <div class="his-item flex">
                    <div class="his-image">
                        <?php
                        $code_prod = $cmsAttributesRepository->findAttributesWithValuesByParams(11, $product->id, 1, 'product');
                        $photos = CmsFiles::find()->where(['id_obj' => $product->id, 'type' => 'product'])
                            ->orderBy('onmain DESC')->all();
                        ?>
                        <img src="<?=$photos[0]->path?>" alt="">
                    </div>
                    <div class="his-desc">
                        <h5><?= $product->idProd->name; ?></h5>
                        <?php if (isset($code_prod)):?>
                            <p><?= $code_prod->cmsAttributesValues[0]->idAttr->name?>: <span><?= $code_prod->cmsAttributesValues[0]->text?></span></p>
                        <?php endif;?>
                        <p><?=Yii::t('trans', 'article')?>: <?= $product->idProd->article; ?></p>
                    </div>
                    <div class="his-count-price flex">
                        <p class="his-count"><?= $product->quantity ?> шт</p>
                        <p class="his-price"><?= $product->price * $product->quantity?> <?=\Yii::$app->params['currency_name']?></p>
                    </div>
                </div>
            <?php endforeach;?>
        <div class="his-payment flex">
            <p>Способ оплаты: <?= $order->payment->name?></p>
            <p>Общая сумма заказа: <?= $order->total_sum?> <?=\Yii::$app->params['currency_name']?></p>
        </div>
        <div class="his-buttons">
            <a href="javascript:void()" data-id="<?=$order->id?>" class="repeat">Повторить заказ</a>
        </div>
    </div>
</div>
<?php endforeach;?>


