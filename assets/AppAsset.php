<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
        'libs/jQuery.mmenu-master/dist/jquery.mmenu.all.css',
        'libs/OwlCarousel2-2.2.1/dist/assets/owl.carousel.min.css',
        'libs/hamburger.css',
        'libs/jquery-ui-1.12.1.custom/jquery-ui.min.css',
        'libs/jQuery-ui-Slider-Pips-master/dist/jquery-ui-slider-pips.min.css',
        'libs/selectize.js-master/dist/css/selectize.css',
        'libs/font-awesome-4.7.0/css/font-awesome.min.css',
        'libs/Magnific-Popup-master/dist/magnific-popup.css',
        'css/main.css?v=2.2',
        'css/footer.css?v=1.02',
        'css/header.css?v=1.05',
        'css/main-page.css',
        'css/product.css'
    ];
    public $js = [
        'js/maskedinput.js',
        'js/feedback.js',
        'libs/jQuery.mmenu-master/dist/jquery.mmenu.all.js',
        'libs/OwlCarousel2-2.2.1/dist/owl.carousel.min.js',
        'libs/jquery-ui-1.12.1.custom/jquery-ui.min.js',
        'libs/jQuery-ui-Slider-Pips-master/dist/jquery-ui-slider-pips.min.js',
        'libs/jquery-ui-touch-punch-master/jquery.ui.touch-punch.min.js',
        'libs/selectize.js-master/dist/js/standalone/selectize.min.js',
        'libs/selectize.js-master/dist/js/selectize.min.js',
        'libs/Magnific-Popup-master/dist/jquery.magnific-popup.min.js',
        'js/mmenu.js',
        'js/nav.js',
        'js/main.js?v=1.01',
        'js/cart/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
