<?php
namespace app\components\widgets\PagesOnMainWidget;

use app\models\Banners;
use app\models\SmapPages;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PagesOnMainWidget extends Widget
{
    public $id_class;
    public $id_par = 0;

    public function run() {

        $pages = SmapPages::find()
            ->where([ 'id_class' => $this->id_class,'visible_'.\Yii::$app->language=>'public_on'])
            ->andWhere(['id_par' => $this->id_par])
//            ->andWhere(['visible_ru' => 'public_on'])
            ->orderBy('prior ASC')
            ->all();
        if ($this->id_par == 62) {
            return $this->render('upper', ['pages' => $pages]);
        } elseif ($this->id_par == 61) {
            return $this->render('index', ['pages' => $pages]);
        }
    }
}