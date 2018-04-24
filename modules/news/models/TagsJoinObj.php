<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the model class for table "tags_join_obj".
 *
 * @property string $id_tag
 * @property string $id_obj
 * @property string $type
 *
 * @property Tags $idTag
 */
class TagsJoinObj extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags_join_obj';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tag', 'id_obj'], 'required'],
            [['id_tag', 'id_obj'], 'integer'],
            [['type'], 'string'],
            [['id_tag'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['id_tag' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Id Tag',
            'id_obj' => 'Id Obj',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTag()
    {
        return $this->hasOne(Tags::className(), ['id' => 'id_tag']);
    }

    /**
     * @inheritdoc
     * @return \app\modules\news\models\query\TagsJoinObjQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\news\models\query\TagsJoinObjQuery(get_called_class());
    }
}
