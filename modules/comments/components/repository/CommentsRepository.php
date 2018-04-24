<?php

namespace app\modules\comments\components\repository;

use app\modules\comments\models\Comments;
use yii\base\Exception;

/**
 * Class CommentsRepository
 * @package app\modules\comments\components\repository
 */
class CommentsRepository
{
    /**
     * @param $model \app\modules\comments\models\Comments[]
     * @return bool
     * @throws Exception
     */
    public function save ($model)
    {

        if (!$model->save()) {
            throw new Exception('Can`t save comment.');
        }

        return true;
    }

    /**
     * @param $idObj
     * @param $type
     * @param $idPar
     * @return array|\app\modules\comments\models\Comments[]
     */
    public function findAll ($idObj, $type, $idPar = 0)
    {
        return Comments::find()
            ->byEntity($idObj, $type)
            //->withUser(\Yii::$app->user->id)
            ->andWhere(['id_par' => $idPar])
            ->withChildren()
            ->status()
            ->newest()
            ->all();
    }
}