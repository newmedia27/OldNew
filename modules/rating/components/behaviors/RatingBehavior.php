<?php

namespace app\modules\rating\components\behaviors;


use app\modules\rating\components\repositories\RatingRepository;
use app\modules\rating\models\Rating;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class RatingBehavior extends Behavior
{
    /**
     * @var RatingRepository
     */
    private $ratingRepository;

    /**
     * @var bool
     */
    public $type = false;

    /**
     * FileBehavior constructor.
     * @param RatingRepository $ratingRepository
     * @param array $config
     */
    public function __construct (RatingRepository $ratingRepository, array $config = [])
    {
        $this->ratingRepository = $ratingRepository;

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_AFTER_INSERT => 'addRating',
        ];
    }

    /**
     * Attached file to created object
     * @param $event
     */
    public function addRating($event)
    {
        /* @var $event->sender is an object that was returned by AR event*/

        if (!empty($event->sender) && isset($_POST['rating'])) {
            $model = new Rating();
            $model->id_comment = $event->sender->id;
            $model->type = $event->sender->type;
            $model->id_obj = $event->sender->id_obj;
            $model->ip_address = $_SERVER['REMOTE_ADDR'];
            $model->rate = $_POST['rating'];
            $this->ratingRepository->saveRating($model);
        }
    }
}