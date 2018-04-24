<?php

namespace app\modules\rating\models;

use Yii;

/**
 * This is the model class for table "rating_total".
 *
 * @property integer $id
 * @property string $type
 * @property integer $id_obj
 * @property integer $id_user
 * @property integer $total
 * @property integer $count
 */
class RatingTotal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating_total';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string'],
            [['id_obj', 'id_user', 'total', 'count'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'id_obj' => 'Id Obj',
            'id_user' => 'Id User',
            'total' => 'Total',
            'count' => 'Count',
        ];
    }

}
