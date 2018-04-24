<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?= Html::beginForm(Url::to(['/search']), 'get', ['class' => 'search-form']) ?>
    <label>
        <?= Html::textInput('q', $text, ['placeholder' => Yii::t('trans', 'search')]) ?>
    </label>
    <input class="submit-search" type="submit" value="<?= Yii::t('trans', 'search_button') ?>">
<?= Html::endForm() ?>