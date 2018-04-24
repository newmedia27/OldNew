<?php
use app\modules\coloring\components\helpers\ColoringHelper;

?>

<ul class="flex filter-refresh_ajax">
    <li><?=Yii::t('trans', 'sort')?></li>
    <li class="cat-filter-wrap">
        <select id="select-sorting" title="" class="filter-select">
            <?php foreach (ColoringHelper::getSortingFilters() as $k => $v):?>
                <option value="<?=$k?>"><?= $v?></option>
            <?php endforeach;?>
        </select>
    </li>
</ul>
