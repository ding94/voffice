<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Package;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

Class PackageController extends Controller
{

	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

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

    /**
   	 * Displays addEdit page
	 * Save data to database if post me
     */
    public function actionAdd()
    {
    	$model = new Package;
    	$model->packageTitle = "Add Package";
    	if($model->load(Yii::$app->request->post()) && $model->save()){
    		return $this->redirect(['index']);
    	}
    	return $this->render('addEdit' ,['model' => $model]);
    }

    /**
   	 * Displays addEdit page
	 * Update data to database if post me
     */
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
    	$model->packageTitle = "Edit Package";
    	if($model->load(Yii::$app->request->post()) && $model->save()){
    		Yii::$app->session->setFlash('success', "Update complted");
    		return $this->redirect(['index']);
    	}
    	return $this->render('addEdit' ,['model' => $model]);
    }

    public function actionDelete($id)
    {
		$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

     /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Package::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}