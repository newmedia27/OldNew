<?php


use app\modules\feedback\models\UploadForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'id' => 'contacts-form',
    'validationUrl' => ['feedback/feedback/validate'],
    'action' => ['feedback/feedback/create'],
    'options' => ['enctype' => 'multipart/form-data','class'=>'main-form']
]); ?>
    <fieldset>
        <ul>
            <li class="input-wrap">
                <label>
                    <span><?=Yii::t('trans', 'username')?></span>
                    <?= $form->field($model, 'name')->textInput()->label(false) ?>
                </label>
            </li>
            <li class="input-wrap">
                <label>
                    <span>E-mail</span>
                    <?= $form->field($model, 'email')->textInput()->label(false) ?>
                </label>
            </li>
            <li class="textarea-wrap">
                <label>
                    <span>Текст сообщения</span>
                    <?= $form->field($model, 'comments')->textarea(['style' => 'resize: none;'])->label(false) ?>
                </label>
            <?= $form->field($model, 'type')->hiddenInput(['value' => 'contacts'])->label(false) ?>
            <li class="submit-wrap flex">

                <input hidden id="question_submit" type="submit" value="Отправить">
                <a href="javascript:void(0)" type="submit"  class="main-button" id="contacts-button">Отправить</a>
            </li>
        </ul>
    </fieldset>
<?php ActiveForm::end(); ?>
