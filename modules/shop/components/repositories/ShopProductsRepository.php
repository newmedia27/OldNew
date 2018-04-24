<?php

namespace app\modules\shop\components\repositories;

use app\models\CmsFiles;
use app\modules\shop\models\ShopProducts;
use Yii;
use yii\db\Expression;

class ShopProductsRepository
{
    public function findPodcastsByCategory ($id)
    {
        return ShopProducts::find()
            ->joinWith('shopProdJoinCats')
            ->where(['shop_prod_join_cat.id_cat' => $id])
            ->orderBy(['created' => SORT_DESC]);
    }

    public function findPodcastsInSubCats ($array)
    {
        return ShopProducts::find()
            ->joinWith('shopProdJoinCats')
            ->where(['shop_prod_join_cat.id_cat' => $array])
            ->orderBy(['created' => SORT_DESC]);
    }

    public function findNewsByTagId ($id)
    {
        return ShopProducts::find()
            ->joinWith('newsJoinTags')
            ->where(['news_join_tags.tag_id' => $id])
            ->andWhere(['news_join_tags.type' => 'product'])
            ->orderBy(['created' => SORT_DESC])
            ->with('cmsFiles');
    }

    public function findNewByAlias ($id, $alias)
    {
        return ShopProducts::find()
            ->joinWith('shopProdJoinCats')
            ->where(['id_cat' => $id])
            ->andWhere(['alias' => $alias])
            ->with('cmsFiles')
            ->one();
    }

    public function findNewsByCatIdSortByRating($catId)
    {
        return ShopProducts::find()
            ->joinWith('shopProdJoinCats')
            ->where(['id_cat' => $catId])
            ->joinWith('ratingTotal')
            ->orderBy(['rating_total.total' => SORT_DESC])
            ->limit(4)->all();
    }

    public function findNewsByCatIdSortByComments()
    {
        $comments = Yii::$app->db->createCommand('
    
        select id_obj,(select count(id) from comments where c.id_obj=id_obj) as num
        from comments c 
        where c.type = \'podcasts\'
        group by id_obj
        order by num desc
            ')
            ->queryAll();
        return $comments;
    }
    public function findNewsByCatIds($catId, $array)
    {
        return ShopProducts::find()
            ->joinWith('shopProdJoinCats')
            ->where(['id_cat' => $catId])
            ->andWhere(['id'=> $array])
            ->limit(4)->all();
    }

    /**
     * @param $id string|array
     * @return \app\modules\shop\models\ShopProducts[]
     */
    public function findOrderProducts ($id)
    {
        return ShopProducts::find()->where(['shop_products.id' => (array)$id])->all();
    }


}