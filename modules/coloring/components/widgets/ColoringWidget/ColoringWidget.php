<?php

namespace app\modules\coloring\components\widgets\ColoringWidget;

use app\modules\shop\components\helpers\PaginatorHelper;
use yii\base\Widget;

class ColoringWidget extends Widget
{
    /**
     * @var \yii\data\ActiveDataProvider
     */
    public $dataProvider;

    public function run ()
    {

        /**
         * Если ajax запрос на подгрузку - пагинация выключается
         */
        if ($this->dataProvider->pagination) {
            $pagination = clone $this->dataProvider->pagination;
        }

        if ($pagination) {
            $lastPage = PaginatorHelper::checkIsLastPage($pagination->getPage(), $pagination->getPageCount());
        } else {
            /**
             * Чтобы получить $this->provider->totalCount нужно включить пагинацию
             * Иначе геттер считает не то, что там нужно
             */
            $this->dataProvider->pagination = [];
            $recordsCount = $this->dataProvider->totalCount;
            $this->dataProvider->pagination = false;
            $lastPage = $this->dataProvider->query->limit + $this->dataProvider->query->offset >= $recordsCount;
        }

        return $this->render('index', [
            'lastPage' => $lastPage,
            'dataProvider' => $this->dataProvider,
        ]);
    }
}