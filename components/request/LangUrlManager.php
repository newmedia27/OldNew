<?php

namespace app\components\request;

use yii\web\UrlManager;
use app\models\Languages;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if( isset($params['id_lang']) ){
            //Если указан идентификатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
            $lang = Languages::findOne($params['id_lang']);
            if( $lang === null ){
                $lang = Languages::getDefaultLang();
            }
            unset($params['id_lang']);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Languages::getCurrent();
        }

        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        //Добавляем к URL префикс - буквенный идентификатор языка
        if( $url == '/' ){
            return '/'.$lang->lang_alias;
        }else{
            if($lang->lang_alias == 'ru'){
                return $url;
            }
            return '/'.$lang->lang_alias.$url;
        }
    }
}
