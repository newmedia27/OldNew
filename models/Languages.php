<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id_lang
 * @property integer $lang_prior
 * @property string $lang_alias
 * @property string $lang_name
 * @property string $lang_visible
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_prior'], 'required'],
            [['lang_prior'], 'integer'],
            [['lang_visible'], 'string'],
            [['lang_alias'], 'string', 'max' => 2],
            [['lang_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_lang' => 'Id Lang',
            'lang_prior' => 'Lang Prior',
            'lang_alias' => 'Lang Alias',
            'lang_name' => 'Lang Name',
            'lang_visible' => 'Lang Visible',
        ];
    }

    //Переменная, для хранения текущего объекта языка
    public static $current = null;

    //Получение текущего объекта языка
    public static function getCurrent () {
        if (self::$current === null) {
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

    //Установка текущего объекта языка и локаль пользователя
    public static function setCurrent ($url = null) {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->lang_alias;
    }

    //Получения объекта языка по умолчанию
    public static function getDefaultLang () {
        return self::find()->where('`lang_prior` = :lang_prior', [':lang_prior' => 1])->one();
    }

    //Получения объекта языка по буквенному идентификатору
    public static function getLangByUrl ($url = null) {
        if ($url === null) {
            return null;
        } else {
            $language = self::find()->where('lang_alias = :lang_alias', [':lang_alias' => $url])->one();
            if ($language === null) {
                return null;
            } else {
                return $language;
            }
        }
    }

    public static function getLangAliases(){
        $langs = self::find()->asArray()->all();
        return ArrayHelper::map($langs, 'id_lang', 'lang_alias');
    }
}
