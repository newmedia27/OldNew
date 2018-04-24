<?php
namespace app\components\widgets\BannersWidget;

use app\models\Banners;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class BannersWidget extends Widget
{
    public $id_pos;
    public $type;
    public $id_obj;

    public function run() {

        if ($this->id_pos) {
            $banners = Banners::find()->with([
                'file' => function($query) {
                    $query->orderBy('cms_files.onmain DESC');
                },])->andWhere(['banners.id_pos' => $this->id_pos])
                ->orderBy('id DESC')->all();
            return $this->render('index', ['banners' => $banners]);
        } else {
            $banners = Banners::find()->joinWith('position')
                ->where(['banner_position.type' => $this->type, 'banner_position.id_obj' => $this->id_obj, 'banners.status' => 'issued'])
                ->orderBy('id DESC')->all();

            return $this->render('index', ['banners' => $banners]);
        }
    }
}