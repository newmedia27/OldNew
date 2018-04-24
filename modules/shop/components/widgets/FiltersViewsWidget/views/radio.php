

<div class="filter-self radio-filter" data-id="radio" data-attr="<?=$attr->id?>">
    <h5><?= $attr->name?></h5>

    <?php if (isset($attr->cmsAttributesVariants)):?>
        <?php foreach ($attr->cmsAttributesVariants as $value){
            $items[$value->id] = $value->name;
            $ids[] = $value->id;
        } ?>
        <?php $attr->name = $ids?>

        <?= $form->field($attr, 'name')->radioList($items,
            ['item' => function($index, $label, $name, $checked, $value) {
                $return = '<label>';
                $return .= '<input type="radio" name="' . $name. '" value="' . $value . '">';
                $return .= '<span>' . ucwords($label) . '</span>';
                $return .= '</label>';
                return $return;
            },'class'=>'filter-radio','id' => "filter-$attr->id",'data-id'=> 'radio']
        )->label(false) ?>
    <?php endif;?>

</div>
