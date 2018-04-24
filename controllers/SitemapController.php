<?php

namespace app\controllers;

use app\models\Languages;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\SmapPages;
use app\models\Sitemap;
use app\modules\shop\models\ShopCategory;

class SitemapController extends Controller
{

    const ALWAYS = 'always';
    const HOURLY = 'hourly';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const NEVER = 'never';

    public $languages = [];
    public $lang_alias = '';
    protected $items = [];
    protected $elements = [];
    protected $classes = [
        'Main' => [self::DAILY, 1],
        'Pages' => [self::WEEKLY, 0.8],
        'CoachSearch' => [self::DAILY, 1],
        'Users' => [self::DAILY, 0.5],
        'Groups' => [self::DAILY, 0.8],
        'Events' => [self::DAILY, 0.8],
    ];

//    public function beforeAction($action)
//    {
//        $this->languages = Languages::getLangAliases();
//        $def = Languages::getDefaultLang()->attributes['lang_alias'];
//        foreach ($this->languages as $key => $language) {
//            if ($def == $language)
//                $language = '';
//            $this->languages[$key] = '/' . $language;
//        }
//
//        return parent::beforeAction($action);
//    }

    public function actionIndex()
    {

        $this->items[] = [
            'loc' => 'https://' . $_SERVER['HTTP_HOST'],
            'changefreq' => $this->classes['Main'][0],
            'priority' => $this->classes['Main'][1]
        ];


        $this->genIndexMap();


    }

    private function genIndexMap()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');

        $sitemapindex = $dom->createElement('sitemapindex');
        $sitemapindex->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemaps/0.9');

        $sitemaps = Sitemap::find()->all();

        foreach ($sitemaps as $item) {

            $sitemap = $dom->createElement('sitemaps');

            $elem = $dom->createElement('loc');

            $elem->appendChild($dom->createTextNode('https://' . $_SERVER['HTTP_HOST'] . '/sitemaps/' . $item->filename));

            $sitemap->appendChild($elem);

            $sitemapindex->appendChild($sitemap);

            $dom->appendChild($sitemapindex);

            $dom->formatOutput = true;
        }

        $dom->save($_SERVER['DOCUMENT_ROOT'] . '/web/uploads/sitemaps/sitemaps.xml');
    }


    public function actionGenerate()
    {


        ini_set("memory_limit", "-1");
        set_time_limit(0);

//        $objects = SmapPages::findAll(['locked' => 'visible', 'visible_ru' => 'public_on']);

        $categories = ShopCategory::find()->where(['id_par' => 1, 'visible' => 1, 'deleted' => 'no',])->select(['id', 'alias', 'id_par'])->all();

        $this->categories($categories);

//        $this->items['pages'][] = ['loc' => 'https://' . $_SERVER['HTTP_HOST'],
//            'changefreq' => $this->classes['Main'][0],
//            'priority' => $this->classes['Main'][1]];

        foreach ($this->elements['categories'] as $item) {
            $this->items['categories'][] = ['loc' => $item,
                'changefreq' => $this->classes['Main'][0],
                'priority' => $this->classes['Main'][1]];
        }

        foreach ($this->elements['products'] as $item) {
            $this->items['products'][] = ['loc' => $item,
                'changefreq' => $this->classes['Main'][0],
                'priority' => $this->classes['Main'][1]];
        }



//        foreach ($objects as $object) {
//            $this->items['pages'][] = ['loc' => 'https://' . $_SERVER['HTTP_HOST'] . '/' . $object->alias,
//                'changefreq' => $this->classes['Pages'][0],
//                'priority' => $this->classes['Pages'][1]];
//        }


        foreach ($this->items as $keys => $item) {

//            echo '<pre>';
//            print_r($key);
//            echo '<pre>';
//            die;
            $count_posts = count($item) / 10000;


            for ($t = 0; $t < $count_posts; $t++) {
                if (isset($item)) {
                    $dom = new \DOMDocument('1.0', 'utf-8');

                    $urlset = $dom->createElement('urlset');

                    $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemaps/0.9');
                    $urlset->setAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');

                    for ($j = $t * 10000; $j < ($t + 1) * 10000; $j++) {
                        if (isset($item[$j])) {

                            $element = $item[$j];

                            $url = $dom->createElement('url');

                            foreach ($element as $key => $value) {
                                $elem = $dom->createElement($key);
                                $elem->appendChild($dom->createTextNode($value));
                                $url->appendChild($elem);
                            }

                            $urlset->appendChild($url);

                            $dom->appendChild($urlset);
                        }
                    }
                }

                $sitemap_model = new Sitemap;
                $sitemap_model->type = $keys;
                $sitemap_model->num = $t;
                $sitemap_model->filename = $sitemap_model->type . "_" . $sitemap_model->num . '.xml';

                $sitemap_model->save();

                $dom->save($_SERVER['DOCUMENT_ROOT'] . '/web/uploads/sitemaps/' . $sitemap_model->filename);
            }
        }
    }

    private function categories($categories, $path = '')
    {

        foreach ($categories as $element) {

            if (count($element->childCats) > 0) {
                $path .= '/' . $element->alias;
                $path = $this->categories($element->childCats, $path);
            } else {
                $this->elements['categories'][] = 'https://' . $_SERVER['HTTP_HOST'] . '/catalog' . $path . '/' . $element->alias;
                if (count($element->idProds) > 0)
                    foreach ($element->idProds as $product)
                        $this->elements['products'][] = 'https://' . $_SERVER['HTTP_HOST'] . '/catalog' . $path . '/' . $product->alias;

            }
        }

    }
}
