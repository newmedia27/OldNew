<?php

namespace app\modules\blog\models;

use app\models\CmsFiles;
use app\modules\blog\models\Tags;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_ua
 * @property string $name_en
 * @property string $alias
 * @property integer $prior
 * @property integer $visible
 * @property string $created
 * @property string $updated
 * @property string $description_ru
 * @property string $description_en
 * @property string $description_ua
 * @property string $description_long_ru
 * @property string $description_long_ua
 * @property string $description_long_en
 * @property string $seo_title_ru
 * @property string $seo_title_ua
 * @property string $seo_title_en
 * @property string $seo_description_ru
 * @property string $seo_description_ua
 * @property string $seo_description_en
 * @property string $seo_keywords_en
 * @property string $seo_keywords_ua
 * @property string $seo_keywords_ru
 * @property string $img_path
 * @property string $img_path_thumb
 * @property string $author_name
 * @property string $author_links
 * @property string $news_date_start
 *
 * @property NewsJoinCat[] $newsJoinCats
 * @property NewsCategory[] $categories
 * @property NewsJoinGroups[] $newsJoinGroups
 * @property NewsGroups[] $groups
 * @property NewsJoinTags[] $newsJoinTags
 * @property NewsTags[] $tags
 */
class News extends \yii\db\ActiveRecord
{
    public $seo_description;
    public $seo_title;
    public $seo_keywords;

    public function afterFind () {

        parent::afterFind();

    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prior', 'visible'], 'integer'],
            [['created', 'updated', 'news_date_start'], 'safe'],
            [['description', 'description_en', 'description_ua', 'description_long_ru', 'description_long_ua', 'description_long_en', 'seo_description_ru', 'seo_description_ua', 'seo_description_en', 'author_links'], 'string'],
            [['name_ru', 'name_ua', 'name_en', 'seo_title_ru', 'seo_title_ua', 'seo_title_en', 'seo_keywords_en', 'seo_keywords_ua', 'seo_keywords_ru', 'img_path', 'img_path_thumb', 'author_name'], 'string', 'max' => 255],
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
            'prior' => 'Prior',
            'visible' => 'Visible',
            'created' => 'Created',
            'updated' => 'Updated',
            'description_ru' => 'Description Ru',
            'description_en' => 'Description En',
            'description_ua' => 'Description Ua',
            'description_long_ru' => 'Description Long Ru',
            'description_long_ua' => 'Description Long Ua',
            'description_long_en' => 'Description Long En',
            'seo_title_ru' => 'Seo Title Ru',
            'seo_title_ua' => 'Seo Title Ua',
            'seo_title_en' => 'Seo Title En',
            'seo_description_ru' => 'Seo Description Ru',
            'seo_description_ua' => 'Seo Description Ua',
            'seo_description_en' => 'Seo Description En',
            'seo_keywords_en' => 'Seo Keywords En',
            'seo_keywords_ua' => 'Seo Keywords Ua',
            'seo_keywords_ru' => 'Seo Keywords Ru',
            'img_path' => 'Img Path',
            'img_path_thumb' => 'Img Path Thumb',
            'author_name' => 'Author Name',
            'author_links' => 'Author Links',
            'news_date_start' => 'News Date Start',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsFiles()
    {
        return $this->hasMany(CmsFiles::className(), ['id_obj' => 'id']) ->andWhere(['type'=>'news']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsJoinCats()
    {
        return $this->hasMany(NewsJoinCat::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(NewsCategory::className(), ['id' => 'category_id'])->viaTable('news_join_cat', ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsJoinGroups()
    {
        return $this->hasMany(NewsJoinGroups::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(NewsGroups::className(), ['id_group' => 'group_id'])->viaTable('news_join_groups', ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsJoinObj()
    {
        return $this->hasMany(TagsJoinObj::className(), ['id_obj' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])->viaTable('tags_join_obj', ['id_obj' => 'id'])->andWhere(['type'=>'news']);
    }

    /**
     * @inheritdoc
     * @return \app\modules\blog\models\queries\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\blog\models\queries\NewsQuery(get_called_class());
    }
}
