<?php foreach ($cats as $cat):?>
    <div class="cat-item flex">
        <h3><a href="<?=\app\components\helpers\PathHelper::categoryPath($cat)?>"><?=$cat->name?></a></h3>
        <div class="cat-img">
            <a href="<?=\app\components\helpers\PathHelper::categoryPath($cat)?>"><img src="<?=$cat->file[0]->path?>" alt=""></a>
        </div>
        <a class="main-button" href="<?=\app\components\helpers\PathHelper::categoryPath($cat)?>"></a>
    </div>
<?php endforeach;?>
