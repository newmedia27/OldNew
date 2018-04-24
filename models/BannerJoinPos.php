<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner_join_pos".
 *
 * @property integer $id_pos
 * @property integer $id_size
 */
class BannerJoinPos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_join_pos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pos', 'id_size'], 'required'],
            [['id_pos', 'id_size'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pos' => 'Id Pos',
            'id_size' => 'Id Size',
        ];
    }
}
