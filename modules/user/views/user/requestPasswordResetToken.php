<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\PasswordResetRequestForm */

use app\components\widgets\Breadcrumbs\Breadcrumbs;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = ['label' => 'Авторизация', 'url'=> '/login'];
$this->params['breadcrumbs'][]['label'] = $this->title;

\app\assets\UserAsset::register($this);
?>

<!--account recover-->
<div class="author-page-wrap">
    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    <div class="register-on-site">
        <h1>Восстановление пароля</h1>

            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'options' => [
                'class' => 'main-form'
            ]]); ?>
            <fieldset>
                <ul>
                    <li class="input-wrap restore_wrap">
                        <label>
                            <?= $form->field($model, 'email')->textInput(['class'=>"form-control"]) ?>
                        </label>
                    </li>
                    <li class="input-wrap">
                        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['captchaAction' => '/user/user/captcha',
                            'template' => '<div class="form-group capcha_block field-phone required"><div class="capch_img">{image}</div>
                                    <a class="btn" id="refresh-captcha"><span class="glyphicon glyphicon-refresh"><img src="/img/main/refresh.png" alt=""></span></a>
                                    <label>
                                        <span></span>
                                        {input}
                                     </label>
                                     </div>',
                            'imageOptions' => [
                                'id' => 'my-captcha-image'
                            ],
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ])->label(false) ?>
                    </li>
                    <li class="submit-wrap flex">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary',]) ?>
                    </li>
                </ul>
            </fieldset>
        <?php ActiveForm::end(); ?>

    </div>
</div>
<!--end account recover-->

<?php $this->registerJs("
    $('#refresh-captcha').on('click', function(e){
        e.preventDefault();

        $('#my-captcha-image').yiiCaptcha('refresh');
    })
"); ?>

<style type="text/css">
    .restore_wrap .form-group {
        width: 100%;
        text-align: right;
    }.restore_wrap .form-group label{
        font-size: 14px;
        margin-top: 6px;
    }
     .restore_wrap .form-group label,  .restore_wrap .form-group input {
        display: inline-block;
        vertical-align: middle;
     }
      .restore_wrap .form-group input, .capcha_block input {
        width: 171px !important;
    }
    .restore_wrap .form-group input{
        margin-left: 20px;
      }
    .restore_wrap .form-group .help-block {
        font-size: 12px;
        margin-top: 4px;
        clear: both;
    }
    .capcha_block {
        margin-top: 20px !important;
    }
</style>
