<?php

namespace app\modules\shop\components\widgets\ProductsViewsWidget;

use app\models\CmsAttributesValues;
use app\modules\shop\components\repositories\ShopCategoryRepository;
use app\modules\shop\models\ShopProducts;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class ProductsViewsWidget extends Widget
{

    public $view;

    public function run ()
    {
        $query = ShopProducts::find()->where(['visible'=>'public']);

        if ($this->view == 'new'){
            //  and av.id_tree=1  I removed
            $query->innerJoin('cms_attributes_values av','av.id_obj = shop_products.id and av.id_attr=2');
            
        }

        if ($this->view == 'sale'){
            
            //$array = ArrayHelper::getColumn(CmsAttributesValues::find()->where(['id_attr'=>2,'type' => 'product', 'id_val'=>'on'])->all(), 'id_obj');
            //array_push($array,0);
            $query->innerJoin('cms_attributes_values av','av.id_obj = shop_products.id and av.id_attr=3');
            //$query->andFilterWhere(['in','id',$array])->orderBy(['creatsd' => SORT_ASC])->limit(4);
        }

        if ($this->view == 'all'){
            $shopCategoryRepository = new ShopCategoryRepository();
            $cat = $shopCategoryRepository->findCategoryByAlias('catalog');
            $cats = $this->findCategoriesIds($cat);
            $query->joinWith('shopProdJoinCats')
                ->andFilterWhere(['in', 'shop_prod_join_cat.id_cat', $cats])->orderBy(['updated' => SORT_DESC])->limit(100);
        }

        $provider = new ActiveDataProvider([
            'query' =>  $query
        ]);

        return $this->render('index', [
            'provider' => $provider->getModels(),
        ]);
    }

    private function findCategoriesIds($cat)
    {
        if ($cat->childCats) {
            foreach ($cat->childCats as $subcat) {
                if ($subcat->childCats) {
                    foreach ($subcat->childCats as $subsubcat) {
                        if ($subsubcat->childCats) {
                            foreach ($subcat->childCats as $subsubsubcat) {
                                $array[] = $subsubsubcat->id;
                            }
                        } else {
                            $array[] = $subsubcat->id;
                        }
                    }
                } else {
                    $array[] = $subcat->id;
                }
            }
        }
        return array_values($array);
    }
}