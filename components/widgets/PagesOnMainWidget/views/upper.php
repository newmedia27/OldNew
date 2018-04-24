<?php foreach ($pages as $item):?>
    <div class="hc-item flex">
        <p><a href="<?=($item->alias=='konkurs-malyarov-2018'?"https://docs.google.com/forms/d/e/1FAIpQLSeTGtFs4zvJN5JSN_I-1GOBlvDBd3N7U3Rp7W8VI8pG5vpdDA/viewform":Yii::$app->request->hostInfo.'/'.$item->alias)?>"><?= $item->name;?></a></p>
        <a href="<?=($item->alias=='konkurs-malyarov-2018'?"https://docs.google.com/forms/d/e/1FAIpQLSeTGtFs4zvJN5JSN_I-1GOBlvDBd3N7U3Rp7W8VI8pG5vpdDA/viewform":Yii::$app->request->hostInfo.'/'.$item->alias)?>"><img src="<?=$item->file[0]->path?>" alt=""></a>
        <a class="main-button" <?=($item->alias=='konkurs-malyarov-2018'?'target="_blank"':'')?> href="<?=($item->alias=='konkurs-malyarov-2018'?"https://docs.google.com/forms/d/e/1FAIpQLSeTGtFs4zvJN5JSN_I-1GOBlvDBd3N7U3Rp7W8VI8pG5vpdDA/viewform":Yii::$app->request->hostInfo.'/'.$item->alias)?>"><span><?=($item->alias=='konkurs-malyarov-2018'?Yii::t('trans', 'registration'):Yii::t('trans', 'more_details'))?></span></a>
    </div>
<?php endforeach;?>