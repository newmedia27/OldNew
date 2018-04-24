<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cms_attributes_variants".
 *
 * @property integer $id
 * @property string $name_ru
 * @property integer $visible
 * @property integer $prior
 * @property integer $id_attr
 * @property string $name_ua
 * @property string $name_en
 *
 * @property CmsAttributes $idAttr
 */
class CmsAttributesVariants extends \yii\db\ActiveRecord
{
    public $name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_attributes_variants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visible', 'prior', 'id_attr'], 'integer'],
            [['name_ru', 'name_ua', 'name_en'], 'string', 'max' => 255],
            [['id_attr'], 'exist', 'skipOnError' => true, 'targetClass' => CmsAttributes::className(), 'targetAttribute' => ['id_attr' => 'id']],
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
            'visible' => 'Visible',
            'prior' => 'Prior',
            'id_attr' => 'Id Attr',
            'name_ua' => 'Name Ua',
            'name_en' => 'Name En',
        ];
    }
    public function afterFind () {

        parent::afterFind();
        $this->name = $this->{"name_" . Yii::$app->language};
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAttr()
    {
        return $this->hasOne(CmsAttributes::className(), ['id' => 'id_attr']);
    }
}
