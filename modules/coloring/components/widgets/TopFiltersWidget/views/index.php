<?php

use app\modules\coloring\components\helpers\ColoringHelper;
use yii\helpers\Html;
?>

<ul class="flex filter-refresh_ajax">
    <li><?=Yii::t('trans', 'sort')?></li>
    <li class="sort" id="select-sorting">
        <span><span class="sort-active">Нові</span></span>
        <ul>
            <?php foreach (ColoringHelper::getSortingFilters() as $k => $v):?>
            <li><a href="javascript:void(0)" data-value="<?=$k?>"><?= $v?></a></li>
            <?php endforeach;?>
        </ul>
    </li>
</ul>