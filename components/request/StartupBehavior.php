<?php

namespace app\components\request;

use app\components\SortList;
use app\models\Languages;
use app\models\SmapPages;
use app\modules\shop\models\ShopProducts;
use yii\base\BootstrapInterface;
use Yii;
use yii\web\HttpException;
use app\modules\shop\models\Currency;

class StartupBehavior implements BootstrapInterface
{

    public function bootstrap($app)
    {
        if (get_class(Yii::$app) == 'yii\web\Application') {
            $abs_url = Yii::$app->request->absoluteUrl;


            \Yii::$app->params['currency'] = Currency::find()->orderBy(['date' => SORT_DESC])->limit(1)->one();

            if (isset(\Yii::$app->params['currency']) && !empty(\Yii::$app->params['currency']))
                \Yii::$app->params['currency'] = \Yii::$app->params['currency']->value;
            else
                \Yii::$app->params['currency'] = 1;

            $set_currency = \Yii::$app->request->get('currency');

            if (isset($set_currency))
                $_SESSION['currency'] = $set_currency;


            if (!isset($_SESSION['currency'])) {
                $_SESSION['currency'] = 'UAH';
            }
            if ($_SESSION['currency'] == 'EUR') {
                \Yii::$app->params['currency'] = 1;
                \Yii::$app->params['currency_name'] = '&euro;';
            } else {
                \Yii::$app->params['currency_name'] = 'грн.';
            }


            Yii::$app->urlManager->className('app\components\request\LangUrlManager');
            $urlManager = Yii::$app->getUrlManager();
            //$urlManager->suffix = '/';
            $urlManager->showScriptName = false;
            $urlManager->enablePrettyUrl = true;
            $lang = Yii::$app->language;

            $url_array = explode('/', Yii::$app->request->url);

            array_shift($url_array);

            $url_last = $url_array[count($url_array) - 1];

            if (preg_match("/(.*)?page=1$/", $abs_url)) {
                $abs_url = str_replace('?page=1', '', $abs_url);
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: " . $abs_url);
                exit();
            }

            if ($url_last == '')
                $url_last = $url_array[count($url_array) - 2];
            $smap_model = SmapPages::find()->where(['alias' => $url_last])->one();

            $sort_list = new SortList();
            $needled_url = '/' . $sort_list->getPath($smap_model->id_par, $smap_model->alias);
            $needled_url = $lang != 'ru' ? '/' . $lang . '/' . $needled_url : $needled_url;
            $current_url = in_array($url_array[0], Languages::getLangAliases()) ? str_replace('/' . $url_array[0], '', Yii::$app->request->url) : Yii::$app->request->url;

            if ($url_array[0] == 'catalog' && ShopProducts::find()->where(['alias' => $url_array[3]])->one() !== NULL)
                $rules = ['catalog/<category:[\w-]+>/<category1:[\w-]+>/<prod:[\w-]+>' => 'shop/shop/view',];
            else
                if (count($smap_model) != 0) {
                    if ($needled_url == $current_url) {
                        if (!empty($smap_model->controller)) {
                            $rules = [
                                'profile/history' => 'user/profile/history',
                                'profile/personal_data' => 'user/profile/personaldata',
                                'blog' => 'blog/blog/index',
                            ];
                        } else {
                            $rules = [
                                'catalog' => 'shop/shop/catalog',
                                'coloring' => 'coloring/coloring/index',
                                '<alias1>' => 'smap/index',
                                '<alias1>/<alias2>' => 'smap/index',
                            ];
                        }
                    } else {
                        if ($smap_model->id_class == 6 || $smap_model->id_class == 8) {
                            $rules = [
                                '<alias1>' => 'smap/other',
                            ];
                        } else {
                            throw new HttpException(404, 'The requested page is not found');
                        }
                    }
                } else
                    $rules = [
                        '/' => 'site/index',
//                    'sitemaps.xml' => 'sitemaps/index',
                        'registration' => 'user/user/signup',
                        'about' => 'site/about',
                        'request-password-reset' => 'user/user/request-password-reset',
                        'reset-password/<token>' => 'user/user/reset-password',
                        'logout' => 'user/user/logout',
                        'login' => 'user/user/login',
                        'login/<service:google|facebook>' => 'user/user/login',
                        'login-submit' => 'user/user/login-submit',
                        'success-signup' => 'user/user/success-signup',
                        'feedback' => 'feedback/feedback/feedback',
                        'feedbacksubmit' => 'feedback/feedback/feedback-submit',
                        'site/UploadFiles' => 'site/upload-files',
                        'site/UploadFiles/<id:\d+>' => 'site/upload-files',
                        'site/DeleteFiles' => 'site/delete-files',
                        'site/DeleteFiles/<id:\d+>' => 'site/delete-files',
                        'cart' => 'cart/cart/index',
                        'checkout' => 'cart/cart/checkout',
                        'cart/thanks' => 'cart/cart/thanks',
                        'cart/add' => 'cart/cart/add-to-cart',
                        'cart/delete' => 'cart/cart/delete-product',
                        'getProdCount' => 'cart/cart/get-product-count',
                        'cart/setData' => 'cart/cart/set-data',
                        'cart/pay' => 'cart/cart/pay',
                        'blog/tags/<tag>' => 'blog/blog/index',
                        'blog/<category>/<news>' => 'blog/blog/view',
                        'blog/<category>' => 'blog/blog/index',
                        'blog' => 'blog/blog/index',
                        'coloring/<tech>' => 'coloring/coloring/view',
                        'coloring' => 'coloring/coloring/index',
                        'search' => 'shop/shop/search',
                        'search/indexing' => 'search/default/indexing',
                        'catalog/<category:[\w-]+>/<category1:[\w-]+>/<category2:[\w-]+>' => 'shop/shop/index',
                        'catalog/<category:[\w-]+>/<category1:[\w-]+>' => 'shop/shop/index',
                        'catalog/<category:[\w-]+>' => 'shop/shop/category',
                        'catalog/<category>/<category1>/<category2>/<prod>' => 'shop/shop/view',
                        '<controller:\w+>/<id:\d+>' => '<controller>/<action>',
                        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    ];

            $urlTag = explode('?', $url_array[3])[0];
            $prod = ShopProducts::find()->where(['alias' => $urlTag])->one();
            if (!$prod) {
                $rules['catalog/<category>/<category1>/<category2>'] = 'shop/shop/index';
            } else {
                $rules['catalog/<category>/<category1>/<prod>'] = 'shop/shop/view';
            }

            $urlTag = explode('?', $url_array[2])[0];
            $prod = ShopProducts::find()->where(['alias' => $urlTag])->one();
            if (!$prod) {
                $rules['catalog/<category>/<category1>'] = 'shop/shop/category';
            } else {
                $rules['catalog/<category>/<prod>'] = 'shop/shop/view';
            }

            $urlManager->rules = $rules;
            $urlManager->init();
        }
    }

}
