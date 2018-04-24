<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\forms\LoginForm */

use app\components\widgets\Breadcrumbs\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

\app\assets\UserAsset::register($this);
$this->title = 'Авторизация';
$this->registerMetaTag(['content' => $this->title,'name'=>'description']);
$this->registerMetaTag(['content' => $this->title,'name'=>'keywords']);

$this->params['breadcrumbs'][]['label'] = 'Авторизация';
?>

<div class="author-page-wrap">
    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    <div class="auth-on-site">
        <h1>Авторизация</h1>
        <div class="aos-wrap flex">

            <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class'=>"main-form"]]); ?>

            <p>Авторизуйтесь и начните <br> Вашу работу на сайте</p>
            <fieldset>
                <ul>
                    <li class="input-wrap">
                        <label>
                            <span>Логин</span>
                            <?= $form->field($model, 'email')->textInput(['class'=>"form-control",'autofocus' => true])->label(false) ?>
                        </label>
                    </li>
                    <li class="input-wrap">
                        <label>
                            <span><?=Yii::t('trans', 'password')?></span>
                            <?= $form->field($model, 'password')->passwordInput(['class'=>"form-control",'autofocus' => true])->label(false) ?>
                        </label>
                    </li>
                    <li class="submit-wrap flex">
                        <a href="/request-password-reset"><?=Yii::t('trans', 'forgot_password')?>?</a>
                        <div class="submit-input">
                            <input type="submit" id="login-button" value="Войти">
                        </div>
                    </li>
                </ul>
            </fieldset>
            <?php ActiveForm::end(); ?>

            <div class="soc-reg">
                <p>Авторизация с помощью<br> социальных сетей</p>
                <a class="main-button" href="/login?service=facebook" data-eauth-service="facebook">Авторизироваться через FACEBOOK</a>
                <a class="main-button google-plus" href="/login?service=google" data-eauth-service="google_oauth">Авторизироваться через GOOGLE+<i class="fa fa-google-plus" aria-hidden="true"></i></a>
                <div class="soc-reg-links flex">
                    <a href="/registration">Нет аккаунта?</a>
                    <a href="/registration"><span><?=Yii::t('trans', 'register')?></span></a>
                </div>
            </div>
        </div>



    </div>
</div>
<?php
if (Yii::$app->getSession()->hasFlash('error')) {
    echo '<div class="alert alert-danger">'.Yii::$app->getSession()->getFlash('error').'</div>';
}
?>