<?php $i=0;
foreach ($tags as $tag): if ($i<100){$i++;?>
    <a href="<?= \Yii::$app->urlManager->createUrl('blog/tags/'.$tag->alias)?>"><?= $tag->name_ru;?><span></span></a>
<?php } endforeach;?>


