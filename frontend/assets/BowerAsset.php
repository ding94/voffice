<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower';
    public $js = [
        'bootstrap/js/modal.js',
        'bootstrap/js/scrollspy.js',
        // 'bootstrap/js/affix.js',
    ];
    public $depends = [
    'frontend\assets\AppAsset',
	
    ];
}