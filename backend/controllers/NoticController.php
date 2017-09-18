<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\models\Notification\Notification;

Class NoticController extends Controller
{
	public function actionIndex($id)
	{
		$model = Notification::find()->where('adminid = :id',[':id' => Yii::$app->user->identity->id ])->all();
		return $this->render('index',['model' => $model]);
	}
}