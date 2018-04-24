<?php
use app\modules\shop\components\helpers\FiltersHelper;
use yii\helpers\Html;
?>
<?php //foreach (FiltersHelper::getSortingFilters() as $k => $v):?>
<!---->
<!--    --><?php //var_dump($k);die;?>
<!---->
<?php //endforeach;?>
<ul class="flex filter-refresh_ajax">
    <li><?=Yii::t('trans', 'sort')?></li>
    <li class="cat-filter-wrap">
        <select id="select-sorting" title="" class="filter-select">
            <?php foreach (FiltersHelper::getSortingFilters() as $k => $v):?>
                <option value="<?=$k?>"><?= $v?></option>
            <?php endforeach;?>
        </select>
    </li>
</ul>
