<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "news_category".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_ua
 * @property string $name_en
 * @property string $alias
 * @property integer $id_par
 * @property integer $prior
 * @property integer $visible
 * @property string $created
 * @property string $updated
 * @property string $description_ru
 * @property string $description_ua
 * @property string $description_en
 * @property string $description_long_ru
 * @property string $seo_title_ru
 * @property string $seo_title_ua
 * @property string $seo_title_en
 * @property string $seo_description_ru
 * @property string $seo_description_en
 * @property string $seo_description_ua
 * @property string $seo_keywords_ru
 * @property string $seo_keywords_en
 * @property string $seo_keywords_ua
 * @property string $img_path
 * @property string $img_path_thumb
 * @property integer $id_lang
 *
 * @property NewsJoinCat[] $newsJoinCats
 * @property News[] $news
 */
class NewsCategory extends \yii\db\ActiveRecord
{
    public $seo_keywords;
    public $seo_title;
    public $seo_description;
    public $name;
    public $description;
    public $description_long;

    public function afterFind () {

        parent::afterFind();
        $this->name = $this->{"name_" . Yii::$app->language};
        $this->seo_title = $this->{"seo_title_" . Yii::$app->language};
        $this->seo_keywords = $this->{"seo_keywords_" . Yii::$app->language};
        $this->seo_description = $this->{"seo_description_" . Yii::$app->language};
        $this->description = $this->{"description_" . Yii::$app->language};
        $this->description_long = $this->{"description_long_" . Yii::$app->language};
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_par', 'prior', 'visible', 'id_lang'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['description_ru', 'description_ua', 'description_en', 'description_long_ru', 'seo_description_ru', 'seo_description_en', 'seo_description_ua'], 'string'],
            [['name_ru', 'name_ua', 'name_en', 'seo_title_ru', 'seo_title_ua', 'seo_title_en', 'seo_keywords_ru', 'seo_keywords_en', 'seo_keywords_ua', 'img_path', 'img_path_thumb'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 155],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'name_ua' => 'Name Ua',
            'name_en' => 'Name En',
            'alias' => 'Alias',
            'id_par' => 'Id Par',
            'prior' => 'Prior',
            'visible' => 'Visible',
            'created' => 'Created',
            'updated' => 'Updated',
            'description_ru' => 'Description Ru',
            'description_ua' => 'Description Ua',
            'description_en' => 'Description En',
            'description_long_ru' => 'Description Long Ru',
            'seo_title_ru' => 'Seo Title Ru',
            'seo_title_ua' => 'Seo Title Ua',
            'seo_title_en' => 'Seo Title En',
            'seo_description_ru' => 'Seo Description Ru',
            'seo_description_en' => 'Seo Description En',
            'seo_description_ua' => 'Seo Description Ua',
            'seo_keywords_ru' => 'Seo Keywords Ru',
            'seo_keywords_en' => 'Seo Keywords En',
            'seo_keywords_ua' => 'Seo Keywords Ua',
            'img_path' => 'Img Path',
            'img_path_thumb' => 'Img Path Thumb',
            'id_lang' => 'Id Lang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsJoinCats()
    {
        return $this->hasMany(NewsJoinCat::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id'])->viaTable('news_join_cat', ['category_id' => 'id']);
    }
}
