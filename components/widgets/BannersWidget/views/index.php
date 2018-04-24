<?php if(isset($banners) && count($banners)>0) foreach ($banners as $item):?>
    <div class="item">
        <?php if(isset($item->url) && !empty($item->url)):?>
        <a href="<?=$item->url;?>" target="<?= $item->blank;?>">
            <img src="<?=($item->file->path_thumb?$item->file->path_thumb:$item->file->path)?>" alt=""/>
        </a>
        <?php else:?>
         <img src="<?=($item->file->path_thumb?$item->file->path_thumb:$item->file->path)?>" alt=""/>
        <?php endif;?>
    </div>
<?php endforeach;?>
