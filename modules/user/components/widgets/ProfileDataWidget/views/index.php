<?php
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\modules\user\components\helpers\ProfileHelper;

?>
<!--Profile Body-->
<div class="profile-body margin-bottom-20">
    <div id="profile" class="profile-edit tab-pane fade in active">
        <h2 class="heading-md">Редактирование личных данных</h2>
        </br>
        <dl class="dl-horizontal" id="profile_tab">

            <?php $form = ActiveForm::begin([
                'id' => 'profile-form',
                'enableAjaxValidation' => true,
                'validationUrl' => [Yii::$app->urlManager->createUrl('user/profile/update')],
                'action' => ['/update-profile-submit'],
            ]); ?>
            <?php foreach ($user as $i => $item): ?>
                <?php if (array_key_exists($i, $model->attributeLabels())): ?>

                    <dt><strong><?= $model->attributeLabels()[$i]; ?> </strong></dt>
                    <dd><span class="empty_field"><?= !empty($item) ? $item : "Поле не заполнено"; ?></span>
                        <span>
                            <?= ProfileHelper::getEditIcon(); ?>
                        </span>
                        <?= $form->field($model, $i)->textInput(['value' => $item])->label(false); ?>
                        <?= ProfileHelper::getEditButtons(); ?>
                    </dd>
                    <hr>
                <?php endif; ?>
            <?php endforeach; ?>

            <dt><strong><?= $model->attributeLabels()['phone']; ?> </strong></dt>
            <dd><span class="empty_field"><?= !empty($profile->phone) ? $profile->phone : "Поле не заполнено"; ?></span>
                <span>
                    <?= ProfileHelper::getEditIcon(); ?>
                </span>
                <?= $form->field($model, 'phone')->textInput(['value' => $profile->phone])->label(false); ?>
                <?= ProfileHelper::getEditButtons(); ?>
            </dd>
            <hr>

            <dt><strong><?= $model->attributeLabels()['birth_date']; ?> </strong></dt>
            <dd>
                <span
                    class="empty_field"><?= !empty($profile->birth_date) ? Yii::$app->formatter->asDate($profile->birth_date, 'dd-MM-yyyy') : "Поле не заполнено"; ?></span>
                <span>
                    <?= ProfileHelper::getEditIcon(); ?>
                </span>
                <?php
                echo $form->field($model, 'birth_date')->label(false)->widget(DatePicker::classname(), [
                    'options' => [
                        'value' => !empty($profile->birth_date) ? Yii::$app->formatter->asDate($profile->birth_date, 'dd-MM-yyyy') : "",
                        'placeholder' => 'Выберите дату',
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy',
                    ],
                ]);
                ?>
                <?= ProfileHelper::getEditButtons(); ?>
            </dd>
            <hr>

            <?php ActiveForm::end(); ?>
        </dl>
    </div>
</div>
<!--End Profile Body-->