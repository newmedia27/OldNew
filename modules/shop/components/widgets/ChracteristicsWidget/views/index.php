<?php foreach ($trees as $tree):?>
    <?php if ($tree->id != 1):?>
        <?php foreach ($tree->idAttrs as $attr): ?>

            <?php $val = \app\models\CmsAttributesValues::find()
                ->where(['id_attr'=>$attr->id, 'id_obj' => $id, 'id_tree'=>$tree->id])
                ->orderBy(['id' => SORT_DESC])
                ->all()?>
            <?php if ($val != null):?>
                <p class="char-desc"><span><?= $attr->name ?> :</span>
                    <span>

                        <?php if($attr->type == 'checkbox'): $string=''?>
                            <?php foreach ($val as $check):?>
                                <?php $string = $string.', '.$check->idVariant->name?>
                            <?php endforeach;?>
                            <?=substr($string, 2);?>
                        <?php elseif($attr->type == 'radio'):?>
                            <?=$val[0]->idVal->name?>
                        <?php elseif($attr->type == 'select'):?>
                            <?=$val[0]->idVariant->name?>

                        <?php elseif($attr->type == 'text'):?>
                            <?=$val[0]->text?>
                        <?php endif;?>

                    </span>
                </p>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>
<?php endforeach;?>