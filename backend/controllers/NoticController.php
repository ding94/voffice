<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\Notification\Notification;

Class NoticController extends Controller
{
	public function actionIndex($id)
	{

		$model =  Notification::find()->where(['adminid' => Yii::$app->user->identity->id]);

		$dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
	        'defaultOrder' => 
		        [
		            'created_at' => SORT_DESC,
		        ]
	    	],
        ]);
		return $this->render('index',['model' => $dataProvider]);
	}
}