<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner_size".
 *
 * @property integer $id
 * @property integer $width
 * @property integer $height
 * @property string $name
 *
 * @property Banners[] $banners
 */
class BannerSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_size';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['width', 'height'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'width' => 'Width',
            'height' => 'Height',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanners()
    {
        return $this->hasMany(Banners::className(), ['id_size' => 'id']);
    }
}
