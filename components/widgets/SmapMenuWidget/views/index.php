<ul class="pa-nav">
    <?php foreach ($models as $model):?>
    <li>
        <a href="<?= Yii::$app->urlManager->createUrl($model->alias)?>" class="<?php if ($url == $model->alias){echo 'active';}?>">
            <?= $model->name;?>
        </a>
    </li>
    <?php endforeach;?>
</ul>

