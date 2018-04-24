<?php foreach ($models as $model):?>
    <ul>
        <?php if (count($model->childCats)>0):?>
            <li class="cf-head"><?= $model->{"name_" . Yii::$app->language};?></li>
            <?php foreach ($model->childCats as $subcat):?>
                <li><a href="<?= \app\components\helpers\PathHelper::categoryPath($subcat) ?>"><?= $subcat->{"name_" . Yii::$app->language};?></a></li>
            <?php endforeach;?>
        <?php else:?>
            <li class="cf-head"><a href="<?= \app\components\helpers\PathHelper::categoryPath($model) ?>"><?= $model->{"name_" . Yii::$app->language};?></a></li>
        <?php endif;?>
    </ul>
<?php endforeach;?>
