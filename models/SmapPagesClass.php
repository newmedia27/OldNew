<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "smap_pages_class".
 *
 * @property integer $id_class
 * @property string $class_name
 * @property integer $locked
 */
class SmapPagesClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smap_pages_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['locked'], 'integer'],
            [['class_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_class' => 'Id Class',
            'class_name' => 'Class Name',
            'locked' => 'Locked',
        ];
    }
}
