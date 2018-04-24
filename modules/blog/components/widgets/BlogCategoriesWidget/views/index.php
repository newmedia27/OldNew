<?php
foreach ($model as $category): ?>
    <a href="<?= Yii::$app->urlManager->createUrl($url[1].'/'.$category->alias)?>"
       class="<?php if ($url[2] == $category->alias){echo 'active';}?>"><?= $category->name;?><span></span></a>
<?php endforeach;?>


