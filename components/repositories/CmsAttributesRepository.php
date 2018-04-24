<?php

namespace app\components\repositories;

use app\models\CmsAttributes;

/**
 * Class CmsAttributesRepository
 * @package app\components\repositories
 */
class CmsAttributesRepository
{
    /**
     * @param $id_attr
     * @param $id_obj
     * @param $id_tree
     * @param $type
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findAttributesWithValuesByParams($id_attr, $id_obj, $id_tree, $type)
    {
        return CmsAttributes::find()
            ->joinWith(['cmsAttributesValues'=>function($query) use ($id_attr, $id_obj, $id_tree, $type) {
                return $query->where(['cms_attributes_values.id_attr' => $id_attr])
                    ->andWhere(['cms_attributes_values.id_obj' => $id_obj])
                    ->andWhere(['cms_attributes_values.id_tree' => $id_tree])
                    ->andWhere(['cms_attributes_values.type' => $type])
                    ->one();
            }])
            ->one();
    }
}