<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sitemaps".
 *
 * @property integer $id
 * @property string $filename
 * @property string $type
 * @property integer $num
 */
class Sitemap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sitemap';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string'],
            [['num'], 'integer'],
            [['filename'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'type' => 'Type',
            'num' => 'Num',
        ];
    }
}
