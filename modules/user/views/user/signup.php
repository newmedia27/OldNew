<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\SignupForm */

use app\components\widgets\Breadcrumbs\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

\app\assets\UserAsset::register($this);
$this->title = Yii::t('trans', 'register');
$this->registerMetaTag(['content' => $this->title,'name'=>'description']);
$this->registerMetaTag(['content' => $this->title,'name'=>'keywords']);

$this->params['breadcrumbs'][] = ['label' => 'Авторизация', 'url'=> '/login'];
$this->params['breadcrumbs'][]['label'] = Yii::t('trans', 'register');
?>

<div class="author-page-wrap">
    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>
    <div class="register-form-wrap">
        <h1><?=Yii::t('trans', 'register')?></h1>
        <?php $form = ActiveForm::begin(['id' => 'form-signup','fieldConfig' => [
            
        ],            'enableAjaxValidation' => true,
            'options' => [
            'class' => 'main-form'
        ]]); ?>
        <p>Авторизуйтесь и начните<br>Вашу работу на сайте</p>
        <fieldset>
            <ul>
                <li class="input-wrap">
                    <label>
                        <span>Логин<i>*</i></span>
                        <?= $form->field($model, 'login')->textInput(['autofocus' => true])->label(false) ?>
                    </label>
                </li>
                <li class="input-wrap">
                    <label>
                        <span>Введите пароль<i>*</i></span>
                        <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
                    </label>
                </li>
                <li class="input-wrap">
                    <label>
                        <span>Повторите пароль<i>*</i></span>
                        <?= $form->field($model, 'password_repeat')->passwordInput()->label(false) ?>
                    </label>
                </li>
                <li class="descr">Введите Ваши личные данные</li>
                <li class="input-wrap">
                    <label>
                        <span><?=Yii::t('trans', 'surname')?></span>
                        <?= $form->field($model, 'surname')->textInput()->label(false)  ?>
                    </label>
                </li>
                <li class="input-wrap">
                    <label>
                        <span><?=Yii::t('trans', 'username')?></span>
                        <?= $form->field($model, 'username')->textInput()->label(false)  ?>
                    </label>
                </li>
                <li class="input-wrap">
                    <label>
                        <span>Отчество</span>
                        <?= $form->field($model, 'secondname')->textInput()->label(false)  ?>
                    </label>
                </li>
                <li class="input-wrap">
                    <label>
                        <span>Контактный телефон</span>
                        <?= $form->field($model, 'phone')->textInput(['class'=>"phone-masked-input"])->label(false) ?>
                    </label>
                </li>
                <li class="input-wrap">
                    <label>
                        <span>E-mail<i>*</i></span>
                        <?= $form->field($model, 'email')->textInput()->label(false) ?>
                    </label>
                </li>
                <li class="descr"><span>* Обязательные поля для заполнения</span></li>
                <li class="submit-wrap flex">
                    <div class="submit-input">
                        <input type="submit" id="signup-button" value="Зарегистрироваться">
                    </div>
                </li>
            </ul>
        </fieldset>
        <?php ActiveForm::end(); ?>
    </div>
</div>