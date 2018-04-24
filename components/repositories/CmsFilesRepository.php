<?php

namespace app\components\repositories;
use app\models\CmsFiles;


/**
 * Class CmsFilesRepository
 * @package app\components\repositories
 */
class CmsFilesRepository
{
    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findPhotosById($id)
    {
        return CmsFiles::find()
            ->joinWith('cmsFilesThumbs')
            ->where(['cms_files.id_obj' => $id])
            ->andWhere(['not like', 'name', '.pdf'])
            ->orderBy(['onmain' => SORT_DESC])
            ->all();
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findDownloadFileById($id)
    {
        return CmsFiles::find()
            ->where(['id_obj' => $id])
            ->andWhere(['like', 'name', '.pdf'])
            ->one();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findPhotosWithImgExtentionById($id)
    {
        return CmsFiles::find()
            ->where(['id_obj' => $id])
            ->andWhere(['type' => 'product'])
            ->andWhere(['like', 'name','.jpg'])
            ->orWhere(['like', 'name', '.png'])
            ->andWhere(['id_obj' => $id])
            ->andWhere(['type' => 'product'])
            ->orderBy(['onmain' => SORT_DESC])
            ->all();
    }

    /**
     * @param $type
     * @param $id
     * @return array|\yii\db\ActiveQuery
     */
    public function findFileByExtention($type, $id)
    {
        return CmsFiles::find()
            ->where(['type'=>$type, 'id_obj'=>$id]);
    }
}