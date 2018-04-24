<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property string $id
 * @property string $name_ru
 * @property string $alias
 * @property string $created_at
 * @property string $updated_at
 * @property string $visible
 * @property string $type
 *
 * @property TagsJoinObj[] $tagsJoinObjs
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'visible'], 'integer'],
            [['type'], 'string'],
            [['name_ru', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'alias' => 'Alias',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'visible' => 'Visible',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsJoinObjs()
    {
        return $this->hasMany(TagsJoinObj::className(), ['id_tag' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\modules\blog\models\queries\TagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\blog\models\queries\TagsQuery(get_called_class());
    }
}
