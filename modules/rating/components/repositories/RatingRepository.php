<?php

namespace app\modules\rating\components\repositories;

use app\modules\rating\models\Rating;
use app\modules\rating\models\RatingTotal;
use yii\base\Exception;

/**
 * Class RatingRepository
 * @package app\modules\rating\components\repositories
 */
class RatingRepository
{
    /**
     * @param Rating $model
     * @return bool
     * @throws Exception
     */
    public function saveRating(\app\modules\rating\models\Rating $model)
    {
        if (!$model->save()){
            throw new Exception('Smth goes wrong!');
        }
        return true;
    }

    /**
     * @param $idComment
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findRatingByIdComment($idComment)
    {
        return Rating::find()->where(['id_comment' => $idComment])->one();
    }

    /**
     * @param $idObj
     * @param $type
     * @param $ipAddress
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findRatingByIdObjTypeAndIpAddress($idObj, $type, $ipAddress)
    {
        return Rating::find()->where(['id_obj' => $idObj, 'type' => $type, 'ip_address' => $ipAddress])->one();
    }

    /**
     * @param $idObj
     * @param $type
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findRatingTotalByIdObjType($idObj, $type)
    {
        return RatingTotal::find()->where(['id_obj' => $idObj, 'type' => $type])->one();
    }

}