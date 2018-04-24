<div class="blog-item flex">
    <div class="bi-img">
        <?php if (!empty($model['cmsFiles'][0])):?>
            <a href="<?= Yii::$app->urlManager->createUrl('blog/' . $model['categories'][0]->alias . '/' . $model->alias) ?>"><img src="<?=Yii::$app->urlManager->createUrl($model['cmsFiles'][0]->path)?>"></a>
        <?php else:?>
        <a href="<?= Yii::$app->urlManager->createUrl('blog/' . $model['categories'][0]->alias . '/' . $model->alias) ?>"><img src="/img/main/blog.jpg">
            </a><?php endif;?>
    </div>
    <div class="bi-desc">
        <h4><a href="<?= Yii::$app->urlManager->createUrl('blog/' . $model['categories'][0]->alias . '/' . $model->alias) ?>"><?= $model->title ?></a></h4>
        <span><?=app\components\helpers\DateHelper::convertDate($model->news_date_start, 'long')?></span>
        <p><?= $model->description ?></p>
        <a class="bi-detailed" href="<?= Yii::$app->urlManager->createUrl('blog/' . $model['categories'][0]->alias . '/' . $model->alias) ?>"><?=Yii::t('trans', 'more_details')?></a>
    </div>
</div>

