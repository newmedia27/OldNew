<div class="panel panel-default panel-account-sidebar">
    <ul>
        <?php
        foreach ($model as $category): ?>
             <li class="<?php if (explode('/',\Yii::$app->request->url)[2] == $category->alias){echo 'active';}?>">
                 <a href="<?= Yii::$app->urlManager->createUrl($url.'/'.$category->alias)?>">
                    <?= $category->name;?>
                 </a>
             </li>
        <?php endforeach;?>
        <li>
            <a href="<?= Yii::$app->urlManager->createUrl('/logout')?>">
                <?= Yii::t('trans', 'log_out') ?>
                <i class="sprite-out"></i>
            </a>
        </li>
    </ul>
</div>
<div class="line"></div>