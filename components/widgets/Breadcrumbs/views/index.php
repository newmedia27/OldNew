<div class="breadcrumbs-wrap">
    <div class="breadcrumbs container-big flex">
        <a href="/"><img src="/img/main/home.png" alt=""></a>
        <?php $i = count($items);?>
        <?php foreach ($items as $element): $i--;?>
            <?php if ($i != 0): ?>
                <a href="<?=$element['url'][0]?>"><span><?=$element['label']?></span></a>
                <?php elseif ($i == 0):?>
                <a href="javascript:void(0)"><span><?=$element['label']?></span></a>
                <?php endif;?>
        <?php endforeach;?>
    </div>
</div>