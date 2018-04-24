<?php
use app\components\BreadcrumbsGen;

use app\components\widgets\Breadcrumbs\Breadcrumbs;
use app\modules\user\components\widgets\CabinetMenuWidget\CabinetMenuWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = $page->name;
$this->registerMetaTag(['content' => $this->title,'name'=>'description']);
$this->registerMetaTag(['content' => $this->title,'name'=>'keywords']);

\app\assets\UserAsset::register($this);
$this->params['breadcrumbs'] = BreadcrumbsGen::getCabinetBreadcrumbs($page);
?>

<div class="my-account-wrap">
    <?= Breadcrumbs::widget(['items'=>$this->params['breadcrumbs']])?>

    <div class="container-big">

        <div class="my-acc-nav">
            <h2><?=$page->name?></h2>
            <?= CabinetMenuWidget::widget()?>
        </div>

        <div class="my-acc-my-data">
            <h2>Личные данные пользователя</h2>
            <?php $form = ActiveForm::begin(['id' => 'form-signup','enableAjaxValidation' => true]); ?>
            <fieldset>
                <?= $form->field($model, 'username')->label(Yii::t('trans', 'surname')) ?>
                <?= $form->field($model, 'surname')->label(Yii::t('trans', 'username')) ?>
                <?= $form->field($model, 'secondname')->label(Yii::t('trans', 'secondname')) ?>
                <?= $form->field($model, 'phone')->label(Yii::t('trans', 'phone')) ?>
                <?= $form->field($model, 'email')->label("Email") ?>
                <div class="submit-wrap">
                    <?= Html::submitButton(Yii::t('trans', 'save'), ['class' => 'btn_tin btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            </fieldset>
            <?php ActiveForm::end(); ?>
            <h2>Изменить пароль</h2>
            <?php $form = ActiveForm::begin(['id' => 'form-password','enableAjaxValidation' => true]); ?>
            <fieldset>
                <?= $form->field($passwordform, 'old_password')->passwordInput()->label("Текущий пароль<span>*</span>") ?>
                <?= $form->field($passwordform, 'password')->passwordInput()->label("Новый пароль<span>*</span>") ?>
                <?= $form->field($passwordform, 'password_repeat')->passwordInput()->label("Повторите новый пароль<span>*</span>") ?>
                <div class="submit-wrap">
                    <?= Html::submitButton(Yii::t('trans', 'save'), ['class' => 'btn btn-primary', 'name' => 'password-button']) ?>
                </div>
            </fieldset>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
