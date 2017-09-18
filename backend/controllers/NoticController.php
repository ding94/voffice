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
	public function actionIndex()
	{
		self::noticeSeen();
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

	public static function noticeSeen()
	{
		$notic = Notification::updateAll(['seen' => 1],'adminid = :id and seen = :s',[':id' => Yii::$app->user->identity->id ,':s' => 0]);
	}
}