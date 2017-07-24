<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;


class ContactController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->request->isAjax)
		{
			
		}
    }

}
