<?php

namespace app\components\behaviors;


use app\models\CmsAttributesValues;
use yii\base\Behavior;
use yii\base\Exception;
use yii\db\BaseActiveRecord;

class CmsAttributesValuesBehavior extends Behavior
{

    /**
     * @var bool
     */
    public $type = false;

    /**
     * FileBehavior constructor.
     * @param array $config
     */
    public function __construct (array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_AFTER_INSERT => 'addCmsAttributesValues',
        ];
    }

    /**
     * Attached file to created object
     * @param $event
     */
    public function addCmsAttributesValues($event)
    {
        /* @var $event->sender is an object that was returned by AR event*/

        if (!empty($event->sender) && isset($_POST['FeedbackForm'])) {
            $model = new CmsAttributesValues();
            $model->id_tree = 13;
            $model->id_attr = 1;
            $model->id_obj = $event->sender->id;
            $model->id_variant = (int)$event->sender->id_obj;
            $model->save();
        }
    }
}