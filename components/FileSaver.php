<?php
namespace app\components;

use app\models\CmsFiles;

use app\modules\feedback\models\UploadForm;
use yii\base\Object;
use yii\helpers\FileHelper;

class FileSaver extends Object
{

    private $_files;
    private $_type;
    private $_dir;
    private $_id_obj;

    public function __construct ($uploadedFile, $type, $id_obj, $config = [])
    {
        $this->_files = $uploadedFile;
        $this->_type = $type;
        $this->_dir = '/web/uploads/' . $this->_type . '/' . date("Y-m-d", time());
        $this->_id_obj = $id_obj;

        parent::__construct($config);
    }

    public function uploadFile ()
    {

        if (FileHelper::createDirectory($_SERVER['DOCUMENT_ROOT'] . $this->_dir, $mode = 0775, $recursive = true)) {

            $upload_model = new UploadForm();
            $upload_model->files = $this->_files;

            if (is_array($this->_files) && $upload_model->validate()) {
                foreach ($this->_files as $file) {
                    $this->saveFile($file);
                }
            } else {
                $this->saveFile($this->_files);
            }

            return true;

        } else {exit('2');
            return false;
        }
    }

    private function saveFile ($file)
    {

        $model = new CmsFiles;
        $name = time() . rand(100, 10000000);

        $file->saveAs($_SERVER['DOCUMENT_ROOT'] . $this->_dir . '/' . $name . '.' . $file->extension, false);
        $model->path = $this->_dir . '/' . $name . '.' . $file->extension;
        $model->type = $this->_type;
        $model->id_obj = $this->_id_obj;
        $model->name = $file->name;
        $model->size = $file->size;

        if (!$model->save()) {
            return false;
        }
    }
}