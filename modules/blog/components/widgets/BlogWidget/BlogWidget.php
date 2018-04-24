<?php

namespace app\modules\blog\components\widgets\BlogWidget;

use app\components\helpers\PaginatorHelper;
use yii\base\Widget;

class BlogWidget extends Widget
{
    /**
     * @var \yii\data\ActiveDataProvider
     */
    public $provider;

    public function run ()
    {
        /**
         * Если ajax запрос на подгрузку - пагинация выключается
         */
        if ($this->provider->pagination) {
            $pagination = clone $this->provider->pagination;
        }

        if ($pagination) {
            $lastPage = PaginatorHelper::checkIsLastPage($pagination->getPage(), $pagination->getPageCount());
        } else {
            /**
             * Чтобы получить $this->provider->totalCount нужно включить пагинацию
             * Иначе геттер считает не то, что там нужно
             */
            $this->provider->pagination = [];
            $recordsCount = $this->provider->totalCount;
            $this->provider->pagination = false;
            $lastPage = $this->provider->query->limit + $this->provider->query->offset >= $recordsCount;
        }

        return $this->render('index', [
            'lastPage' => $lastPage,
            'provider' => $this->provider,
        ]);
    }
}