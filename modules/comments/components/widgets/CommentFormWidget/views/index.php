<?php

use yii\widgets\ActiveForm;
//use app\modules\files\components\widgets\FileFormWidget\FileFormWidget;

/* @var $this yii\web\View */
/* @var $model \app\modules\comments\models\forms\CommentsForm */
/* @var $form ActiveForm */

?>

<div class="write-comments">
    <?php $form = ActiveForm::begin([
        'id' => 'write_message_form',
        'enableAjaxValidation' => true,
        'validationUrl' => [Yii::$app->urlManager->createUrl('/comments/comments/validate')],
        'action' => ['/comments/comments/create'],

    ]); ?>
        <h5>Оставьте комментарий</h5>
        <div class="text-wrap">
            <?= $form->field($model, 'text')->textarea(['rows' => 1, 'onclick' => 'setResizeble(this);', 'id'=>"comment_text",'style' => 'resize: none;', 'placeholder' => 'Введите текст здесь'])->label(false); ?>
            <?= $form->field($model, 'id_obj')->hiddenInput(['value' => $idObj, 'id' => 'comment-noraiting-obj-id'])->label(false); ?>
            <?= $form->field($model, 'type')->hiddenInput(['value' => $type, 'id' => 'comment-noraiting-type'])->label(false); ?>
            <?= $form->field($model, 'id_par')->hiddenInput(['value' => $idPar, 'id' => 'comment-noraiting-parent'])->label(false); ?>
            <?= $form->field($model, 'id_user')->hiddenInput(['value' => Yii::$app->user->identity->id, 'id' => 'comment-user'])->label(false); ?>
        </div>
        <input id="comment_send"  class="submit-comment" style="display: none;" type="submit" value="Комментировать">

    <a href="javascript:void(0);" class="submit-comment" >Комментировать</a>
    <?php ActiveForm::end(); ?>
</div>

