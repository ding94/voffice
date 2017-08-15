<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User\User;
use common\models\User\UserSearch;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelSearch;
use backend\models\Admin;
use backend\modules\logistics\controllers\ParcelStatusNameController;
Class UserController extends CommonController
{
	public function actionIndex()
	{
		$searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}

	public function actionView($id)
	{
		$user = User::find()->where('id = :id',[':id' => $id])->joinwith('userdetail')->one();
		
		$searchModel = new ParcelSearch;
		$dataProvider = $searchModel->searchparceldetail(Yii::$app->request->queryParams,$id);

		$list = ParcelStatusNameController::listStatus();
		
        return $this->render('view',['user' => $user ,'dataProvider' => $dataProvider , 'searchModel'=> $searchModel ,'list' => $list]);
		
	}
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->status = 0;
		if($model->update(false) !== false)
		{
			Yii::$app->session->setFlash('warning', "Delete completed");
		}
		else{
			Yii::$app->session->setFlash('warning', "Fail to delete");
		}
       return $this->redirect(Yii::$app->request->referrer);
	}

	public function actionActive($id)
	{
		$model = $this->findModel($id);
		$model->status = 10;
		if($model->update(false) !== false)
		{
			Yii::$app->session->setFlash('success', "Active completed");
		}
		else{
			Yii::$app->session->setFlash('warning', "Fail to Active");
		}
        return $this->redirect(['index']);

	}

	/**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}