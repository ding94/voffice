<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/vo.css',
        'css/font-awesome.min.css',
		'css/slideshow.css',
		'css/test.css',
		
    ];
    public $js = [
        'js/vo.js',
		'js/slideshow.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
		'iutbay\yii2fontawesome\FontAwesomeAsset',
    ];
}