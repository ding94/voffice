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

	public function actionAdd()
	{
		$model = new AdminControl();
		$model->scenario = 'addAdmin';
		$model->adminTittle = "Add Admin";
		if($model->load(Yii::$app->request->post()))
		{
			if($model->add())
			{
				Yii::$app->session->setFlash('success', "Add complted");
    			return $this->redirect(['index']);
			}
		}
		return $this->render('addEdit' ,['model' => $model]);
	}
}
