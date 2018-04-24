<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="site-error">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><?= Html::encode($this->title) ?></h1>
                <div class="alert alert-danger">
                    <?= nl2br(Html::encode($message)) ?>
                </div>
                <p>The above error occurred while the Web server was processing your request.</p>
                <p>Please contact us if you think this is a server error. Thank you.</p>
            </div>
        </div>
    </div>
</div>

<style>
.site-error {
    text-align: center;
    padding-bottom: 100px;
}
.site-error h1 {
    font-size: 40px;
    font-weight: 400;
    margin: 40px 0;
}
.alert {
    font-size: 20px;
    margin: 20px 0;
    font-weight: 400;
}
.site-error p {
    font-size: 16px;
    font-weight: 300;
    margin: 16px 0;
}
</style>