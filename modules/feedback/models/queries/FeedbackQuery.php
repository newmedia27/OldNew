<?php

use yii\db\ActiveQuery;

class FeedbackQuery extends ActiveQuery
{
    public function type($type)
    {
        return $this->andWhere(['type' => $type]);
    }
}