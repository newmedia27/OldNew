<?php

use app\components\helpers\PathHelper;

$thumb = \app\models\CmsFilesThumb::find()->where(['id_file' => $model->file[0]->id, 'size' => 1])->one();
?>
<div class="blog-item flex">
    <div class="bi-img">
            <a href="<?= PathHelper::productPath($model) ?>"><img src="<?= !empty($thumb->path) ? $thumb->path : ($model->file[0]->path_thumb?$model->file[0]->path_thumb:$model->file[0]->path) ?>"></a>

    </div>
    <div class="bi-desc">
        <h4><a href="<?= PathHelper::productPath($model) ?>"><?= $model->name ?></a></h4>
        <p><?= $model->description ?></p>
        <a class="bi-detailed" href="<?= PathHelper::productPath($model) ?>"><?=Yii::t('trans', 'more_details')?></a>
    </div>
</div>


