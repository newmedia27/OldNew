<?php
foreach ($tags as $tag): ?>
    <a href="<?= \Yii::$app->urlManager->createUrl('blog/tags/'.$tag->alias)?>"><?= $tag->name_ru;?><span></span></a>
<?php endforeach;?>


