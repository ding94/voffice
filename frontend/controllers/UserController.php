<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$this->layout = 'user';
        return $this->render('index');
    }

}
