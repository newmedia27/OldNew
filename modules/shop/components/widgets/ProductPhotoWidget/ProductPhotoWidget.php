<?php

namespace app\modules\shop\components\widgets\ProductPhotoWidget;

use app\models\CmsFiles;
use yii\base\Widget;
use Yii;

class ProductPhotoWidget extends Widget
{
    public $id_obj;
    public $name;
    public $type;
    public $attr;

    public function run ()
    {

        $photos = CmsFiles::find()->where(['id_obj' => $this->id_obj, 'type' => $this->type])->orderBy('onmain DESC')->all();
        $gallery = [];

        foreach ($photos as $photo) {
            $thumb = $photo->getThumbs()->all();
            $gallery[(!empty($thumb[1]->path)?$thumb[1]->path:$photo->path)] = !empty($thumb[1]->path)?$thumb[1]->path:$photo->path;
            $i++;
        }

        return $this->render('index', ['gallery' => $gallery, 'attr' => $this->attr, 'main_thumb' => $main_thumb, 'name' => $this->name]);
    }
}
