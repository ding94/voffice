<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Package;

Class PackageController extends Controller
{
	/**
     * Displays package homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    	$searchModel = new Package();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
   		//var_dump($dataProvider);exit;
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
    }

    public function actionAdd()
    {
    	$model = new Package;
    	$model->packageTitle = "Add Package";
    	if($model->load(Yii::$app->request->post()) && $model->save()){
    		return $this->redirect(['index']);
    	}
    	return $this->render('addEdit' ,['model' => $model]);
    }

     public function actionEdit()
    {
    	
    }

}