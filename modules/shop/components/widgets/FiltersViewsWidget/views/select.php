<div class="filter-self f-select " data-id="select" data-attr="<?=$attr->id?>">
    <h5><?= $attr->name?></h5>
    <div class="cat-filter-wrap">
        <?php if (isset($attr->cmsAttributesVariants)):?>
            <?php foreach ($attr->cmsAttributesVariants as $value){$items[$value->id] = $value->name;} ?>
            <?= $form->field($attr, 'name')->dropDownList($items,
                ['prompt' => 'Отфильтровать...', 'id' => "filter-$attr->id", 'class'=>'filter-select','data-id'=> 'select',]
            )->label(false) ?>
        <?php endif;?>
    </div>
</div>