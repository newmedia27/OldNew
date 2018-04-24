<?php
namespace app\components\widgets\CategoriesWidget;

use app\modules\shop\models\ShopCategory;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class CategoriesWidget extends Widget
{
    public $id_par = 0;

    public function run() {
        $query = ShopCategory::find()->where(['id_par' => $this->id_par,'visible'=>1])->orderBy('prior');
        $provider = new ActiveDataProvider([
          'query' => $query
        ]);
        return $this->render('index', [
            'models' => $provider->getModels(),
        ]);
    }
}