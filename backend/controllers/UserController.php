<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\UserParcel;
Class UserController extends Controller
{
	public function actionIndex()
	{
		$searchModel = new User();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}

	public function actionView($id)
	{
		$model = $this->findModel($id);
        
        $parcel = UserParcel::find()->where('uid = :id' ,[':id' => $id])->all();
        if(!empty($parcel)) {

             return $this->render('view',['model' => $model, 'pid'=>$parcel]);
             
        }
        else{
            return $this->render('view',['model' => $model]);
        }
		
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