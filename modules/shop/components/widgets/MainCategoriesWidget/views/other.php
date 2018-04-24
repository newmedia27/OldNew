<?php foreach ($cats as $cat):?>
    <div class="cat-item flex">
        <h3><a class="main-button" href="<?=\app\components\helpers\PathHelper::categoryPath($cat)?>"><?=$cat->name?></a></h3>
<!--        <a class="main-button" href="--><?//=\app\components\helpers\PathHelper::categoryPath($cat)?><!--"></a>-->
    </div>
<?php endforeach;?>