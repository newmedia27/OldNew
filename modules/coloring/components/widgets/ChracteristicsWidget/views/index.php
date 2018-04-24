<?php foreach ($trees as $tree):?>
    <?php if ($tree->id != 1):?>
        <?php foreach ($tree->idAttrs as $attr): ?>
            <?php $val = \app\models\CmsAttributesValues::find()
                ->where(['id_attr'=>$attr->id, 'id_obj' => $id, 'id_tree'=>$tree->id])
                ->orderBy(['id' => SORT_DESC])
                ->all()?>
            <?php if ($val != null):?>
                <h3><?= $attr->name ?></h3>
                <div class="blog-category flex">
                        <?php if($attr->type == 'checkbox'): $string=''?>
                            <?php foreach ($val as $check):?>
                                <a class="active"><?=$check->idVariant->name?><span></span></a>
                            <?php endforeach;?>
                        <?php elseif($attr->type == 'radio'):?>
                            <a class="active"><?=$val[0]->idVal->name?><span></span></a>

                        <?php elseif($attr->type == 'select'):?>
                            <a class="active"><?=$val[0]->idVariant->name?><span></span></a>

                        <?php elseif($attr->type == 'text'):?>
                            <a class="active"><?=$val[0]->text?><span></span></a>
                        <?php endif;?>

                </div>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>
<?php endforeach;?>