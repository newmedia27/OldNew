<?php
namespace app\components\widgets\FooterWidget;

use app\components\repositories\SmapPagesRepository;
use yii\base\Widget;

class FooterWidget extends Widget
{
    public $prior;

    public function run()
    {
        $smapPagesRepository = new SmapPagesRepository;
        $items = $smapPagesRepository->findMenuItemsByIdClass(2);
        return $this->render('index', array('items' => $items));
    }
}