<?php use yii\helpers\Html;

$arrays = array_chunk($items, 3);
?>
<footer class="main-footer">
    <div class="container flex">
        <div class="foot-logo">
            <a href="/"><img src="/img/footer/footer.png" alt=""></a>
            <span>2012-<?= date('Y') ?> Colormarket. Все права защищены</span>
        </div>

        <div class="foot-soc flex">
            <p class="foot-phone"><?= Yii::t('trans', 'phone_1') ?></p>
            <ul>
                <li><a href="<?= Yii::t('trans', 'url_facebook_page') ?>"><span></span></a></li>
                <li><a href="<?= Yii::t('trans', 'url_youtube_page') ?>"><span></span></a></li>
            </ul>
        </div>
        <div class="foot-nav-wrap flex">
            <?php foreach ($arrays as $array): ?>
                <ul class="foot-nav">
                    <?php foreach ($array as $item): ?>
                        <li><?php echo Html::a($item->name, Yii::$app->urlManager->createUrl('/' . $item->alias)); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>
        <div class="creator">
            <a class="flex" href="http://goresh.net" target="_blank">
                <span>Сайт создан в<br> Goresh.net</span>
                <img src="/img/footer/goresh.png" alt="">
            </a>
        </div>
    </div>
</footer>
