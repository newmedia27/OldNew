<?php
namespace app\modules\shop\models;


use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $date
 * @property string $type
 * @property integer $main
 * @property string $value
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['type'], 'string'],
            [['main'], 'integer'],
            [['value'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'type' => 'Type',
            'main' => 'Main',
            'value' => 'Value',
        ];
    }
}