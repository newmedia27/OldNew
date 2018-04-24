<?php
namespace app\components\widgets\HeaderWidget;

use app\components\repositories\SmapPagesRepository;
use yii\base\Widget;

class HeaderWidget extends Widget
{
    public $prior;

    public function run()
    {
        $smapPagesRepository = new SmapPagesRepository;
        $items = $smapPagesRepository->findMenuItemsByIdClass(3);
        return $this->render('index', array('items' => $items));
    }
}