<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="center">
                    <h1><?= Html::encode($this->title) ?></h1>

                    <p>Введите Ваш новый пароль:</p>

                    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])->label(false) ?>

                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .site-reset-password {
        text-align: center;
        font-size: 16px;
        padding-bottom: 200px;
    }
    .site-reset-password h1 {
        font-size: 26px;
        color: #6e6f71;
        margin: 0;
        margin: 26px 0;
        font-weight: 400;
    }
    .site-reset-password p {
        margin-bottom: 0;
    }
    .site-reset-password .form-group {
        padding: 0 0 10px;
        width: 300px;
        max-width: 100%;
        margin: 0 auto;
    }
    .site-reset-password .form-group input {
        margin: 10px 0;
        height: 40px;
        width: 100%;
        border: 1px solid #cfcfcf;
        font-size: 14px;
        padding-left: 10px;
        border-radius: 4px;
    }
    .site-reset-password .form-group .help-block {
        display: block;
        margin: 0 0 5px;
        color: red;
    }
    .site-reset-password .btn {
        background-color: #fcab51;
        font-size: 12px;
        color: #FFFFFF;
        padding-right: 10px;
        -webkit-border-radius: 0 20px 20px 0;
        height: 40px;
        padding: 0 26px;
        border-radius: 4px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border: none;
    }
</style>