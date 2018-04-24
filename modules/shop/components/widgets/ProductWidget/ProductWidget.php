<?php

namespace app\modules\shop\components\widgets\ProductWidget;

use app\modules\shop\components\helpers\PaginatorHelper;
use yii\base\Widget;
use app\modules\shop\models\Currency;

class ProductWidget extends Widget
{
    /**
     * @var \yii\data\ActiveDataProvider
     */
    public $provider;
    public $maxPrice;

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
        
      $currency = Currency::find()->orderBy(['date'=>SORT_DESC])->limit(1)->one();
        
        return $this->render('index', [
            'lastPage' => $lastPage,
            'provider' => $this->provider,
            'maxPrice' => $this->maxPrice*$currency->value
        ]);
    }
}