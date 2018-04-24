<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property integer $id_size
 * @property integer $id_pos
 * @property string $name
 * @property string $status
 * @property string $payfor
 * @property integer $lifetime
 * @property string $type
 * @property string $url
 * @property string $image
 * @property string $text
 * @property string $blank
 *
 * @property BannerStatus $bannerStatus
 * @property BannerPosition $idPos
 * @property BannerSize $idSize
 */
class Banners extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_size', 'id_pos', 'lifetime'], 'integer'],
            [['status', 'payfor', 'type', 'text', 'blank'], 'string'],
            [['text'], 'required'],
            [['name', 'url', 'image'], 'string', 'max' => 200],
            [['id_pos'], 'exist', 'skipOnError' => true, 'targetClass' => BannerPosition::className(), 'targetAttribute' => ['id_pos' => 'id']],
            [['id_size'], 'exist', 'skipOnError' => true, 'targetClass' => BannerSize::className(), 'targetAttribute' => ['id_size' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_size' => 'Id Size',
            'id_pos' => 'Id Pos',
            'name' => 'Name',
            'status' => 'Status',
            'payfor' => 'Payfor',
            'lifetime' => 'Lifetime',
            'type' => 'Type',
            'url' => 'Url',
            'image' => 'Image',
            'text' => 'Text',
            'blank' => 'Blank',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannerStatus()
    {
        return $this->hasOne(BannerStatus::className(), ['id_ban' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPos()
    {
        return $this->hasOne(BannerPosition::className(), ['id' => 'id_pos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSize()
    {
        return $this->hasOne(BannerSize::className(), ['id' => 'id_size']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile ()
    {
        return $this->hasOne(CmsFiles::className(), ['id_obj' => 'id'])->andWhere(['type'=>'banner']);
    }
}
