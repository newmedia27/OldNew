<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21.03.2018
 * Time: 11:18
 */

namespace app\controllers;


use app\modules\shop\models\ShopCategory;
use yii\web\Controller;
use Yii;


class SitemapController extends Controller
{
    public $items = [];

    public function actionIndex()
    {

        $categories = ShopCategory::find()->where(['id_par' => 1, 'visible' => 1, 'deleted' => 'no',])->select(['id', 'alias', 'id_par'])->all();

        $this->categories($categories);
foreach ($this->items['categories'] as $item){
    echo '<pre>';
    print_r($item);
    echo '</pre>';die();
}
        echo '<pre>';
        print_r($this->items);
        echo '</pre>';


//        var_dump($this->items['products']);
//        exit();
/*        echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;*/
//        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
//        foreach ($this->items as $item) {
//
//            echo '<url>
//                <loc>' . $item . '</loc>
//
//
//               <changefreq>daily</changefreq>
//               <priority>0.5</priority>
//           </url>';
//        }
//        echo '</urlset>';
//        Yii::$app->end();


    }

    private function categories($categories, $path = '')
    {

        foreach ($categories as $item) {

            if (count($item->childCats) > 0) {
                $path .= '/' . $item->alias;
                $path = $this->categories($item->childCats, $path);
            } else {
                $this->items['categories'][] = 'http://' . $_SERVER['HTTP_HOST'] . '/catalog' . $path . '/' . $item->alias;
                if (count($item->idProds) > 0)
                    foreach ($item->idProds as $product)
                        $this->items['products'][] = 'http://' . $_SERVER['HTTP_HOST'] . '/catalog' . $path . '/' . $product->alias;

            }
        }

    }


}