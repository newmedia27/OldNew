<?php

namespace app\modules\comments\models;

//use app\modules\files\components\behaviors\FileBehavior;
//use app\modules\user\models\User;
use app\modules\raiting\components\behaviors\RaitingBehavior;
use app\modules\raiting\models\Raiting;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_obj
 * @property string $text
 * @property string $type
 * @property string $token
 * @property string $username
 * @property string $email
 * @property integer $id_par
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User[] $users
 * @property Comment[] $children
 */
class Comments extends \yii\db\ActiveRecord
{
    public $token;

    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return 'comments';
    }

    public function behaviors ()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('UNIX_TIMESTAMP(NOW())'),
            ],
//            [
//                'class' => FileBehavior::className()
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['id_obj', 'type', 'text'], 'required'],
            [['id_user', 'id_obj', 'id_par', 'created_at', 'updated_at'], 'integer'],
            [['text', 'type','username','email'], 'string'],
            ['token', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_obj' => 'Id Obj',
            'text' => 'Text',
            'type' => 'Type',
            'id_par' => 'Id Par',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\comments\models\queries\CommentsQuery the active query used by this AR class.
     */
    public static function find ()
    {
        return new \app\modules\comments\models\queries\CommentsQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getUsers ()
//    {
//        return $this->hasMany(User::className(), ['id' => 'id_user']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren ()
    {
        return $this->hasMany(self::className(), ['id_par' => 'id'])->status();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRaiting ()
    {
        return $this->hasMany(Raiting::className(), ['id_comment' => 'id']);
    }

}
