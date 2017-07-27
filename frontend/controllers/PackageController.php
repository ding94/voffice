<?php

namespace frontend\controllers;

use common\models\Package;


class PackageController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$package = Package::find()->all();

        return $this->render('index',[
                'package' => $package,
            ]);
    }

}
