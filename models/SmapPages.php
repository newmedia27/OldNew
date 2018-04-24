<?php

namespace app\models;

use app\components\SortList;
use Yii;

/**
 * This is the model class for table "smap_pages".
 *
 * @property integer $id
 * @property integer $id_par
 * @property integer $id_class
 * @property integer $prior
 * @property string $alias
 * @property string $name_ru
 * @property string $name_en
 * @property string $name_ua
 * @property string $office_menu_alias
 * @property string $text_ru
 * @property string $text_en
 * @property string $text_ua
 * @property string $title_ru
 * @property string $title_en
 * @property string $title_ua
 * @property string $reference
 * @property string $patern
 * @property string $type
 * @property string $locked
 * @property integer $pic_position
 * @property integer $id_photo_type_1
 * @property integer $block_type
 * @property string $link
 * @property integer $id_photo_type
 * @property string $keywords_ru
 * @property string $keywords_en
 * @property string $keywords_ua
 * @property string $description_ru
 * @property string $description_en
 * @property string $description_ua
 * @property string $pic_on_ru
 * @property string $pic_on_en
 * @property string $pic_on_ua
 * @property string $pic_roll_ru
 * @property string $pic_roll_en
 * @property string $pic_roll_ua
 * @property string $pic_off_ru
 * @property string $pic_off_en
 * @property string $pic_off_ua
 * @property string $visible_ru
 * @property string $visible_en
 * @property string $visible_ua
 * @property string $page_img_ru
 * @property string $page_img_en
 * @property string $page_img_ua
 * @property double $size_ru
 * @property double $size_en
 * @property double $size_ua
 * @property string $smap_text_ru
 * @property string $smap_text_en
 * @property string $smap_text_ua
 * @property string $controller
 * @property string $h1_ru
 * @property string $h1_ua
 * @property string $h1_en
 */
class SmapPages extends \yii\db\ActiveRecord
{

    public $cat;
    public $visible;
    public $name;
    public $title;
    public $smap_text;
    public $keywords;
    public $description;
    public $text;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smap_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_par', 'id_class', 'prior', 'pic_position', 'id_photo_type_1', 'block_type', 'id_photo_type'], 'integer'],
            [['name_ru', 'name_en', 'title_ru', 'title_en', 'title_ua', 'reference', 'keywords_ru', 'keywords_en', 'keywords_ua', 'description_ru', 'description_en', 'description_ua', 'pic_off_ru'], 'required'],
            [['text_ru', 'text_en', 'text_ua', 'title_ru', 'title_en', 'title_ua', 'reference', 'type', 'locked', 'keywords_ru', 'keywords_en', 'keywords_ua', 'description_ru', 'description_en', 'description_ua', 'visible_ru', 'visible_en', 'visible_ua', 'smap_text_ru', 'smap_text_en', 'smap_text_ua'], 'string'],
            [['size_ru', 'size_en', 'size_ua'], 'number'],
            [['alias', 'name_ru', 'name_en', 'name_ua', 'pic_on_ru', 'pic_on_en', 'pic_on_ua', 'pic_roll_ru', 'pic_roll_en', 'pic_roll_ua', 'pic_off_ru', 'pic_off_en', 'pic_off_ua'], 'string', 'max' => 100],
            [['office_menu_alias', 'controller', 'h1_ru', 'h1_ua', 'h1_en'], 'string', 'max' => 255],
            [['patern'], 'string', 'max' => 20],
            [['link'], 'string', 'max' => 200],
            [['page_img_ru', 'page_img_en', 'page_img_ua'], 'string', 'max' => 150],
            [['id_par', 'alias', 'id_class'], 'unique', 'targetAttribute' => ['id_par', 'alias', 'id_class'], 'message' => 'The combination of Id Par, Id Class and Alias has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_par' => 'Id Par',
            'id_class' => 'Id Class',
            'prior' => 'Prior',
            'alias' => 'Alias',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
            'name_ua' => 'Name Ua',
            'office_menu_alias' => 'Office Menu Alias',
            'text_ru' => 'Text Ru',
            'text_en' => 'Text En',
            'text_ua' => 'Text Ua',
            'title_ru' => 'Title Ru',
            'title_en' => 'Title En',
            'title_ua' => 'Title Ua',
            'reference' => 'Reference',
            'patern' => 'Patern',
            'type' => 'Type',
            'locked' => 'Locked',
            'pic_position' => 'Pic Position',
            'id_photo_type_1' => 'Id Photo Type 1',
            'block_type' => 'Block Type',
            'link' => 'Link',
            'id_photo_type' => 'Id Photo Type',
            'keywords_ru' => 'Keywords Ru',
            'keywords_en' => 'Keywords En',
            'keywords_ua' => 'Keywords Ua',
            'description_ru' => 'Description Ru',
            'description_en' => 'Description En',
            'description_ua' => 'Description Ua',
            'pic_on_ru' => 'Pic On Ru',
            'pic_on_en' => 'Pic On En',
            'pic_on_ua' => 'Pic On Ua',
            'pic_roll_ru' => 'Pic Roll Ru',
            'pic_roll_en' => 'Pic Roll En',
            'pic_roll_ua' => 'Pic Roll Ua',
            'pic_off_ru' => 'Pic Off Ru',
            'pic_off_en' => 'Pic Off En',
            'pic_off_ua' => 'Pic Off Ua',
            'visible_ru' => 'Visible Ru',
            'visible_en' => 'Visible En',
            'visible_ua' => 'Visible Ua',
            'page_img_ru' => 'Page Img Ru',
            'page_img_en' => 'Page Img En',
            'page_img_ua' => 'Page Img Ua',
            'size_ru' => 'Size Ru',
            'size_en' => 'Size En',
            'size_ua' => 'Size Ua',
            'smap_text_ru' => 'Smap Text Ru',
            'smap_text_en' => 'Smap Text En',
            'smap_text_ua' => 'Smap Text Ua',
            'controller' => 'Controller',
            'h1_ru' => 'H1 Ru',
            'h1_ua' => 'H1 Ua',
            'h1_en' => 'H1 En',
        ];
    }


    public function afterFind () {

        parent::afterFind();
        $this->visible = $this->{"visible_" . Yii::$app->language};
        $this->name = $this->{"name_" . Yii::$app->language};
        $this->title = $this->{"title_" . Yii::$app->language};
        $this->smap_text = $this->{"smap_text_" . Yii::$app->language};
        $this->keywords = $this->{"keywords_" . Yii::$app->language};
        $this->description = $this->{"description_" . Yii::$app->language};
        $this->text = $this->{"text_" . Yii::$app->language};
    }

    public function getList () {
        $data = SmapPages::find()->where(['id_class' => 1, 'visible_'.Yii::$app->language => 'public_on'])->orderBy('prior ASC')->asArray()->all();
        $sort = new SortList($data);
        $sort->finalPrintMenu();
    }

    public function getMobileList () {
        $data = SmapPages::find()->where(['id_class' => 1, 'visible_'.Yii::$app->language => 'public_on'])->orderBy('prior ASC')->asArray()->all();
        $sort = new SortList($data);
        $sort->finalPrintMobileMenu();
    }

    public function getFile() {
        return $this->hasMany(CmsFiles::className(), ['id_obj' => 'id'])->andWhere(['type'=>'smap'])->orderBy('date DESC');
    }
}
