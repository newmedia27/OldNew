<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \frontend\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/reset-password/'.$data['user']->password_reset_token]);
?>
<div class="password-reset">
    <p>Здравствуйте, <?= Html::encode($data['user']->username) ?>,</p>

    <p>Перейдите по ссылке для восстановления Вашего пароля:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
