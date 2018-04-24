<?php
/* @var $comment \app\modules\comments\models\Comments */

use app\modules\comments\components\helpers\CommentHelper;
use app\modules\comments\components\widgets\AnswerAdminWidget\AnswerAdminWidget;

?>
<div class="comments-self">
    <?php if (empty($comments)) : ?>
    <div class="comment-self">
        <div class="cs-info">
            <p>Комментариев нет.</p>
        </div>
    </div>
    <?php else : ?>

    <h5>Всего <?= count($comments)?> комментариев</h5>
        <?php foreach ($comments as $comment) :?>
            <?php $user = \app\modules\user\models\User::findOne(['id'=>$comment->id_user])?>
            <div class="comment-self">
                <div class="cs-info">
                    <p><span><?= $user->username.' '.$user->surname ?></span><?= CommentHelper::getCommentTime($comment->created_at); ?></p>
                </div>
                <p class="cs-text"><?= nl2br($comment->text); ?></p>
            </div>
        <?php endforeach;?>

<!--    <div class="pagination-wrap flex">-->
<!--        <a href="#" class="main-button"><span>Загрузить больше товаров</span></a>-->
<!--        <ul class="pagination">-->
<!--            <li><a class="active" href="#">1</a></li>-->
<!--            <li><a href="#">2</a></li>-->
<!--            <li><a href="#">3</a></li>-->
<!--            <li><a href="#">...</a></li>-->
<!--            <li><a href="#">8</a></li>-->
<!--            <li><a href="#">9</a></li>-->
<!--            <li><a href="#">10</a></li>-->
<!--        </ul>-->
<!--    </div>-->
    <?php endif;?>
</div>

