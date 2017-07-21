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
		if($model->load(Yii::$app->request->post()) && $model->add())
		{

			Yii::$app->session->setFlash('success', "Add completed");
    		return $this->redirect(['index']);
		}
		return $this->render('addEdit' ,['model' => $model]);
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->scenario = 'changeAdmin';
		$model->passwordOff = '1';
		if($model->load(Yii::$app->request->post()) && $model->save())
		{
			Yii::$app->session->setFlash('success', "Update completed");
    		return $this->redirect(['index']);
		}
		return $this->render('addEdit', ['model' => $model]);
	}

	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->status = 0;
		if($model->update(false) !== false)
		{
			Yii::$app->session->setFlash('success', "Delete completed");
		}
		else{
			Yii::$app->session->setFlash('success', "Fail to delete");
		}
        return $this->redirect(['index']);
	}

  	/**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
