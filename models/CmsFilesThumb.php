<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cms_files_thumb".
 *
 * @property integer $id
 * @property string $path
 * @property integer $size
 * @property integer $id_file
 *
 * @property CmsFiles $idFile
 * @property CmsFilesThumbSize $size0
 */
class CmsFilesThumb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_files_thumb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path'], 'string'],
            [['size', 'id_file'], 'integer'],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => CmsFiles::className(), 'targetAttribute' => ['id_file' => 'id']],
            [['size'], 'exist', 'skipOnError' => true, 'targetClass' => CmsFilesThumbSize::className(), 'targetAttribute' => ['size' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'size' => 'Size',
            'id_file' => 'Id File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFile()
    {
        return $this->hasOne(CmsFiles::className(), ['id' => 'id_file']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize0()
    {
        return $this->hasOne(CmsFilesThumbSize::className(), ['id' => 'size']);
    }
}
