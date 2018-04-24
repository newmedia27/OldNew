<div class="panel panel-default panel-account-sidebar">
    <ul>
        <?php
        foreach ($model as $category): ?>
             <li class="<?php if (explode('/',\Yii::$app->request->url)[2] == $category->alias){echo 'active';}?>">
                 <a href="<?= \app\components\helpers\PathHelper::categoryPath($category) ?>">
                    <?= $category->name;?>
                 </a>
             </li>
        <ul>
            <?foreach ($category->childCats as $cat): ?>
                <li class="<?php if (explode('/',\Yii::$app->request->url)[2] == $cat->alias){echo 'active';}?>">
                    <a href="<?= \app\components\helpers\PathHelper::categoryPath($cat) ?>">
                        <?= $cat->name;?>
                    </a>
                </li>
                <ul>
                    <?foreach ($cat->childCats as $categ): ?>
                        <li class="<?php if (explode('/',\Yii::$app->request->url)[2] == $categ->alias){echo 'active';}?>">
                            <a href="<?= \app\components\helpers\PathHelper::categoryPath($categ) ?>">
                                <?= $categ->name;?>
                            </a>
                        </li>

                    <?php endforeach;?>
                </ul>
            <?php endforeach;?>
        </ul>
        <?php endforeach;?>
    </ul>
</div>
<div class="line"></div>