<div class="filter-self check-filter" data-id="checkbox" data-attr="<?=$attr->id?>">
    <h5><?= $attr->name?></h5>
    <?php if (isset($attr->cmsAttributesVariants)):?>
        <?php foreach ($attr->cmsAttributesVariants as $value):?>
            <?php $items[$value->id] = $value->name?>
            <?php $ids[] = $value->id?>
        <?php endforeach;?>
        <?php $attr->name = $ids?>
        <?= $form->field($attr, 'name')->checkboxList($items,[
            'item' => function($index, $label, $name, $checked, $value) {

                $return = '<label class="filter-checkbox">';
                $return .= '<input type="checkbox" name="' . $name . '" value="' . $value . '">';
                $return .= '<span>' . ucwords($label) . '</span>';
                $return .= '</label>';
                return $return;
            },'id' => "filter-$attr->id",'data-id'=> 'checkbox']
        ) ?>
    <?php endif;?>
</div>
