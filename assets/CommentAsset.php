<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class CommentAsset
 * @package app\assets
 */
class CommentAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/comments/main.css'
    ];
    public $js = [
        'js/comments/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
