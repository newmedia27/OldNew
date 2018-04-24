<?php

namespace app\modules\rating\models;

use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property integer $id
 * @property string $type
 * @property integer $id_obj
 * @property integer $id_user
 * @property string $ip_address
 * @property integer $rate
 * @property integer $id_comment
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string'],
            [['id_obj', 'id_user', 'rate', 'id_comment'], 'integer'],
            [['ip_address'], 'string', 'max' => 255],
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
            'ip_address' => 'Ip Address',
            'rate' => 'Rate',
            'id_comment' => 'Id Comment',
        ];
    }
}
