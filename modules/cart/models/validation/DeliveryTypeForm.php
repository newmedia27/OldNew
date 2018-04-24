<?php

namespace app\modules\cart\models\validation;

use yii\base\Model;

class DeliveryTypeForm extends Model
{
    public $name;

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return [
            'name' => 'Способ доставки',
        ];
    }
}