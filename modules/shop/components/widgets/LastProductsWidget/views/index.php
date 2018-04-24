<?php foreach ($provider as $model):?>

<?php $thumb = \app\models\CmsFilesThumb::find()->where(['id_file' => $model->file[0]->id, 'size' => 1])->one();?>
    <div class="item">
        <div class="pi-image">
            <a href="<?=\app\components\helpers\PathHelper::productPath($model)?>"><img src="<?=($thumb->path?$thumb->path:$model->file[0]->path)?>" alt=""></a>
        </div>
            <a href="<?=\app\components\helpers\PathHelper::productPath($model)?>"><p class="pi-name"><?= $model->name?></p></a>
        <span class="cur-price"><?= $model->price . ' '.\Yii::$app->params['currency_name']?> </span>
        <a href="<?=\app\components\helpers\PathHelper::productPath($model)?>"></a>
    </div>
<?php endforeach;?>
