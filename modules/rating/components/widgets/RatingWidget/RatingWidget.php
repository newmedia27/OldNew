<?php

namespace app\modules\rating\components\widgets\RatingWidget;

use app\modules\rating\components\repositories\RatingRepository;
use app\modules\rating\components\services\RatingService;
use yii\base\Widget;

/**
 * Class RatingWidget
 * @package app\modules\rating\components\widgets\RatingWidget
 */
class RatingWidget extends Widget
{
    /**
     * @var string
     */
    public $tpl = 'show';
    /**
     * @var int
     */
    public $idComment = 0;
    /**
     * @var
     */
    public $idObj;
    /**
     * @var
     */
    public $type;

    /**
     * @return string
     */
    public function run ()
    {
        $servise = new RatingService(new RatingRepository());
        return $this->render($this->tpl,[
            'comment' => $servise->getRatingByIdComment($this->idComment),
            'total' => $servise->getRating($this->idObj, $this->type)
        ]);
    }

}