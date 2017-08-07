<?php

namespace backend\modules\finance\controllers;
use common\models\OfflineTopup;

use Yii;

class TopupController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $searchModel = new OfflineTopup();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
    }
	
	 public function actionUpdate($id)
    {
    	
        //$model = OfflineTopup::find()->where('id = :id',[':id' => $id])->one();
		//var_dump($model);exit;
	    //return $this->render('update', ['model' => $model]);
		$model = $this->findModel($id);
		$model->action = 3;
	
		$model->inCharge = Yii::$app->user->identity->adminname;
		if($model->update(false) !== false)
		{
			Yii::$app->session->setFlash('success', "Update success");
		}
		else{
			Yii::$app->session->setFlash('danger', "Fail to Update");
		}
        return $this->redirect(['index']);
	}
	
	public function actionCancel($id)
	{
		
		$model = OfflineTopup::find()->where('id = :id',[':id' => $id])->one();
		
		if($model->load(Yii::$app->request->post()) && $model->update())
		{
			$model->action =4;
			$model->inCharge = Yii::$app->user->identity->adminname;
			$model->save(false);
			Yii::$app->session->setFlash('success', "Update completed");
    		return $this->redirect(['index']);
		}
    		
		return $this->render('update', ['model' => $model]);

		
		
	}
	
	
	/*public function actionCancel($id)
	{
		$model = $this->findModel($id);
		$model->action = 4;
		if($model->save(false) !== false)
		{
			Yii::$app->session->setFlash('success', "Cancel success");
		}
		else{
			Yii::$app->session->setFlash('danger', "Fail to Cancel");
		}
        return $this->redirect(['index']);

	}
	*/
	  protected function findModel($id)
    {
        if (($model = OfflineTopup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
}
