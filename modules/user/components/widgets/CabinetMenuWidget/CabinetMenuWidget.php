<?php
namespace app\modules\user\components\widgets\CabinetMenuWidget;
use app\models\SmapPages;
use yii\base\Widget;

class CabinetMenuWidget extends Widget
{
    public function run ()
    {
        $smap = SmapPages::find()
            ->where(['alias' => 'profile'])
            ->one();

        $categories = SmapPages::find()
            ->where(['id_par' => $smap->id])
            ->orderBy(['prior' => SORT_ASC])
            ->all();

        return $this->render('index',[
            'model' => $categories,
            'url' => 'profile'
        ]);
    }

}