<?php

namespace app\modules\comments\models\forms;

use yii\base\Model;

class CommentsForm extends Model
{

    public $text;
    public $id_obj;
    public $id_user;
    public $type;
    public $id_par;
    public $file;
    public $token;
    public $username;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['id_obj', 'type', 'text'], 'required'],
            [['id_user', 'id_obj', 'id_par'], 'integer'],
            [['text', 'type','username','email'], 'string'],
            [['text'], 'required', 'message' => \Yii::t('trans', 'comment_required')],
            ['token', 'safe'],
            ['email','email'],
            ['file', 'file', 'extensions' => ['jpeg', 'jpg', 'png', 'bmp', 'xlsx', 'xls', 'doc', 'docx', 'txt', 'pdf', 'mp4', '3gp']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return [
            'text' => 'Текст комментария',
        ];
    }
}