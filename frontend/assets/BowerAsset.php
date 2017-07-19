<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower';
    public $js = [
        'bootstrap/js/modal.js',
    ];
    public $depends = [
    'frontend\assets\AppAsset',
    ];
}