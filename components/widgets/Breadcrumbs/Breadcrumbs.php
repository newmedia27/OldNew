<?php
namespace app\components\widgets\Breadcrumbs;

use app\components\repositories\SmapPagesRepository;
use yii\base\Widget;

class Breadcrumbs extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('index', array('items' => $this->items));
    }
}