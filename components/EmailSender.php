<?php
namespace app\components;

use yii\base\Object;
use Yii;

class EmailSender extends Object {

    public $email;
    public $text;
    public $view;
    public $subject;
    public $files;


    public function sendMail(){

        $email = Yii::$app
            ->mailer
            ->compose(['html' => $this->view, 'text' => $this->view], ['text' => $this->text])
            ->setFrom(\Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject($this->subject);

        if(!empty($this->files)){
            foreach ($this->files as $file) {
                $server_file = $_SERVER['DOCUMENT_ROOT'].$file;
                $email->attach($server_file);
            }
        }

        if ($email->send()) {
            return true;
        }

        return false;
    }
}