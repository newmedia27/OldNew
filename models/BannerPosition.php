<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner_position".
 *
 * @property integer $id
 * @property string $visible
 * @property string $name
 * @property integer $rot_time
 * @property string $type
 * @property integer $id_obj
 *
 * @property Banners[] $banners
 */
class BannerPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visible', 'type'], 'string'],
            [['rot_time', 'id_obj'], 'integer'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visible' => 'Visible',
            'name' => 'Name',
            'rot_time' => 'Rot Time',
            'type' => 'Type',
            'id_obj' => 'Id Obj',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanners()
    {
        return $this->hasMany(Banners::className(), ['id_pos' => 'id']);
    }
}
