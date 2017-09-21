<?php

namespace backend\controllers;

use Yii;
use common\models\News;

Class NewsController extends CommonController
{
	public function actionIndex()
	{
		$searchModel = new News();
       	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index',['model' => $dataProvider]);
	}

	public function actionAddnews()
	{
		$model = new News();

		if(Yii::$app->request->post())
		{
			$post = Yii::$app->request->post();
			$model->load($post);
			if ($model->validate()) {
				$model->save();
				Yii::$app->session->setFlash('success', 'Upload Successful');
				return $this->redirect(['index']);
			}
		}

		return $this->render('addnews',['model' => $model]);
	}

	public function actionDelete($id)
	{
		$model = News::find()->where('id = :id',[':id'=>$id])->one();
		if ($model) {
			$model->delete();
		}
		return $this->redirect(['index']);
	}

	public function actionUpdate($id)
	{

	}
}