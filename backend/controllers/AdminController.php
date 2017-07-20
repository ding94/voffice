<?php

namespace backend\controllers;

use yii\web\Controller;
use backend\models\Admin;
use backend\models\AdminControl;
use yii\filters\VerbFilter;
use Yii;

Class AdminController extends Controller
{
	/**
     * Displays admin homepage.
     *
     * @return string
     */
	public function actionIndex()
	{
		$searchModel = new AdminControl();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}
}
