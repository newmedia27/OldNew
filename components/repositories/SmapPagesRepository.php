<?php

namespace app\components\repositories;
use app\models\SmapPages;
use Yii;

/**
 * Class SmapPagesRepository
 * @package app\components\repositories
 */
class SmapPagesRepository
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findMenuItemsByIdClass($idClass){
        return SmapPages::find()
            ->where(['visible_'.Yii::$app->language => "public_on"])
            ->andWhere(['id_par' => 0])
            ->andWhere(['id_class' => $idClass])
            ->orderBy('prior ASC')
            ->all();
    }
}