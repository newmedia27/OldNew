<?php

/* @var $this yii\web\View */
/* @var $user \frontend\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/reset-password/', 'token' => $user->password_reset_token]);
?>
Здравствуйте, <?= $user->username ?>,

Перейдите по ссылке для восстановления Вашего пароля:

<?= $resetLink ?>
