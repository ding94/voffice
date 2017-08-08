<?php

namespace backend\modules\finance\controllers;
use common\models\OfflineTopup;
use common\models\User\UserBalance;
use common\models\User\User;

use Yii;

class TopupController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $searchModel = new OfflineTopup();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams,0);
 
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
    }
	
	 public function actionUpdate($id)
    {
    	
		$model = $this->findModel($id);
		
		if ($model->action == 1)
		{
		$uid = User::find()->where('username = :name',[':name'=>$model->username])->one()->id;
		$balance =UserBalance::find()->where('uid = :name',[':name'=>$uid])->one();
		$balance ->balance += $model->amount;
		$balance ->positive += $model->amount;
		$model->action = 3;
		$model->inCharge = Yii::$app->user->identity->adminname;
		
		if($model->update(false) !== false)
		{
			$balance->save(false);
			Yii::$app->session->setFlash('success', "Update success");
		}
		else{
			Yii::$app->session->setFlash('error', "Fail to Update");
		}
	}
	elseif ($model->action !=1){
		
		Yii::$app->session->setFlash('error', "Top up already confirmed!");
	}
        return $this->redirect(['index']);
	}
	
	public function actionCancel($id)
	{
		// Cancel function incomplete
		$model = OfflineTopup::find()->where('id = :id',[':id' => $id])->one(); 
		//var_dump($model->load(Yii::$app->request->post())); exit;
		if ($model->action == 1 || $model->action == 2){
			
			
			//var_dump($model->update()); exit;
			$model->action =4;
			$model->inCharge = Yii::$app->user->identity->adminname;
			$model->save(false);
			
			Yii::$app->session->setFlash('success', "Cancel success");
    		return $this->redirect(['index']);
		
    		
		//return $this->render('update', ['model' => $model]);

		}
		elseif ($model->action ==3 || $model->action ==4){
		
		Yii::$app->session->setFlash('error', "Action cancelled!");
		}
		
		
		return $this->redirect(['direct']);
	}
	
	
    public function actionDirect()
    {
     // var_dump(Yii::$app->request->post('pending')); exit;
	  
	   $searchModel = new OfflineTopup();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams,Yii::$app->request->post('action'));
	
       return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
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
