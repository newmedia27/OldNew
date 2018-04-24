<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

?>
<div class="password-reset">
    Спасибо за регистрацию на сайте<br>
    Ваши личные данные не будут переданы третьим лицам.<br>
<br>
Вход в личный кабинет <a href="https://colormarket.online/login">https://colormarket.online/login</a>
<br>
    Ваш логин: <?= Html::encode($data[user]->email)?><br>
    Ваш пароль: <?= Html::encode($data['password'])?><br>
    

    Чтобы изменить свои личные данные, перейдите по ссылке:<br>

    Команда Colormarket
</div>
