<?php foreach ($pages as $item):?>
    <div class="cap-item">
        <p><?= $item->name;?></p>
        <div class="cap-item-image">
            <a href="<?= Yii::$app->request->hostInfo.'/'.$item->alias;?>"><img src="<?=$item->file[0]->path?>" alt=""></a>
        </div>
        <span><?= $item->smap_text;?></span>
        <a class="main-button" href="<?= Yii::$app->request->hostInfo.'/'.$item->alias;?>"><span><?=Yii::t('trans', 'more_details')?></span></a>
    </div>
<?php endforeach;?>