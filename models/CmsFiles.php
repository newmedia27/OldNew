<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cms_files".
 *
 * @property integer $id
 * @property integer $id_obj
 * @property string $name
 * @property string $path
 * @property string $date
 * @property string $code
 * @property integer $size
 * @property string $token
 * @property string $type
 * @property integer $onmain
 * @property integer $prior
 * @property string $path_thumb
 * @property string $file_type
 * @property integer $id_comm
 *
 * @property CmsFilesThumb[] $cmsFilesThumbs
 */
class CmsFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_obj', 'name', 'path', 'code', 'size', 'path_thumb'], 'required'],
            [['id_obj', 'size', 'onmain', 'prior', 'id_comm'], 'integer'],
            [['name', 'path', 'type', 'path_thumb'], 'string'],
            [['date'], 'safe'],
            [['code'], 'string', 'max' => 40],
            [['token', 'file_type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_obj' => 'Id Obj',
            'name' => 'Name',
            'path' => 'Path',
            'date' => 'Date',
            'code' => 'Code',
            'size' => 'Size',
            'token' => 'Token',
            'type' => 'Type',
            'onmain' => 'Onmain',
            'prior' => 'Prior',
            'path_thumb' => 'Path Thumb',
            'file_type' => 'File Type',
            'id_comm' => 'Id Comm',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsFilesThumbs()
    {
        return $this->hasMany(CmsFilesThumb::className(), ['id_file' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThumbs()
    {
        return $this->hasMany(CmsFilesThumb::className(), ['id_file' => 'id']);
    }
}
