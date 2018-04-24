<?php

use yii\widgets\ListView;

?>

<?php
$visible = $lastPage ? 'none' : 'none';
?>

<?= ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '_list',
    'layout' => "{items}
                 <div class='pagination-wrap flex'>
                     <div class='text-center' style='display:" . $visible . "'>
                          <a href='' id='download-more' class='main-button'><span>Загрузить больше статей</span></a>
                     </div>
                 {pager}
                 </div>",
    'summary' => false,
    'pager' => [
        'prevPageLabel' => '&laquo;',
        'nextPageLabel' => '&raquo;',
        'maxButtonCount' => 5,
        'options' => [
            'class' => 'pagination',
        ],
        'linkOptions' => ['class' => 'pager-item'],
        'activePageCssClass' => 'active',
        'disabledPageCssClass' => '',
        'prevPageCssClass' => '',
        'nextPageCssClass' => '',
    ],
]);
?>