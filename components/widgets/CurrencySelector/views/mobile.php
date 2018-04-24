<?php
use yii\helpers\Html;

$uaAlias = Yii::$app->controller->getRoute() == 'site/index' ? '/' : '';
?>

<li>
    <span class="top-lang flex">
        <a class="active" href="javascript: void(0);"><?= strtoupper($current->lang_alias); ?></a>
        <?php foreach ($langs as $lang): ?>
            <?php if($lang->lang_alias != $current->lang_alias):?>
                <span>|</span>
                <?php $alias = $lang->lang_alias != 'ru' ? '/'.$lang->lang_alias : $ruAlias; ?>
                <?= Html::a(strtoupper($lang->lang_alias), $alias.Yii::$app->getRequest()->getLangUrl()) ?>
            <?php endif;?>
        <?php endforeach; ?>
    </span>
</li>
