<?php

namespace backend\modules\finance\controllers;
use common\models\OfflineTopup\OfflineTopup;
use common\models\User\UserBalance;
use common\models\User\User;
use common\models\OfflineTopup\OfflineTopupOperate;
use common\models\OfflineTopup\OfflineTopupStatus;
use common\models\BankDetails;
use backend\modules\finance\controllers\OfflineTopupOperateController;
use backend\modules\finance\controllers\OfflineTopupStatusController;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;



use Yii;

class TopupController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $searchModel = new OfflineTopup();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams,1);
	   $list = ArrayHelper::map(OfflineTopupStatus::find()->all() ,'title' ,'title');
		$name=ArrayHelper::map(BankDetails::find()->all() ,'id' ,'bank_name');
		//var_dump($name);exit;
       return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel , 'list'=>$list,'name'=>$name]);
    }
	
	public function actionUpdate($id)
    {
		//var_dump($id);exit;
		$model = $this->findModel($id);
		if ($model->action == 1)
		{
			$balance = self::saveBalance($model);
			 
			self::updateAllTopup($id,3);
			$model->action = 3;
			$model->inCharge = Yii::$app->user->identity->id;
			//var_dump($model->inCharge); exit; 
			if($model->update(false) !== false)
			{
				$balance->save();
			//	self::updateAllTopup();
				Yii::$app->session->setFlash('success', "Topup Success!");
			}
			else{
				Yii::$app->session->setFlash('error', "Fail to Topup");
			}
		}
		elseif ($model->action !=1){
			Yii::$app->session->setFlash('error', "Topup has been opreated! Action Denied!");
		}
        return $this->redirect(['index']);
	}
	
	protected static function saveBalance($model)
	{
		//var_dump($model); exit;
		
	
		$balance =UserBalance::find()->where('uid = :name',[':name'=>$model->uid])->one();
		//var_dump($balance);exit;
		$balance ->balance += $model->amount;
		$balance ->positive += $model->amount;
		
		return $balance;
	}
	
	public function actionUndos($id)
	{
		$model = OfflineTopup::find()->where('id = :id',[':id' => $id])->one(); 
		
		
		if ($model->action == 3)
		{
			self::updateAllTopup($id,1);
			$balance = self::deductBalance($model);
			if($model->amount > $balance->balance){
			Yii::$app->session->setFlash('warning', "Fail to undo");
			return $this->redirect(['direct']);
		}
			$balance->save();
			
			//var_dump($balance->validate(); exit;
				if($model->update() !== false)
			{
				//var_dump($model);exit;
				
				$model->action =$model->action_before;
				$model->save();
				Yii::$app->session->setFlash('success', "Undo success");
	    		 return $this->redirect(['index']);
			}
			else
			{
				
				Yii::$app->session->setFlash('warning', "Fail to undo");
			}
				
			return $this->redirect(['direct']);
		}
		
	}
	
	protected static function deductBalance($model)
	{
		
		$balance =UserBalance::find()->where('uid = :name',[':name'=>$model->uid])->one();
		$balance ->balance -= $model->amount;
		$balance ->positive -= $model->amount;
		
		return $balance;
	}
	
	public function actionCancel($id)
	{
		// Cancel function incomplete
		$model = OfflineTopup::find()->where('id = :id',[':id' => $id])->one(); 
		//var_dump($model->load(Yii::$app->request->post())); exit;
		if ($model->action == 1 || $model->action == 2){
			
			if($model->load(Yii::$app->request->post()))
			{
				//var_dump($model->update()); exit;
			self::updateAllTopup($id,4);
			$model->action =4;
			$model->inCharge = Yii::$app->user->identity->id;
			$model->save();
			
			Yii::$app->session->setFlash('success', "Topup rejected!");
    		 return $this->redirect(['index']);
			}
			    		
		return $this->render('update', ['model' => $model]);

		}
		elseif ($model->action ==3 || $model->action ==4){
		
		Yii::$app->session->setFlash('error', "Topup has been Confirmed! Action denied!");
		}
		
		
		return $this->redirect(['direct']);
	}
	
	
	public function actionUndo($id)
	{
		$model = OfflineTopup::find()->where('id = :id',[':id' => $id])->one(); 
		$model->rejectReason= "";
		//var_dump($model->load(Yii::$app->request->post())); exit;
		if ($model->action == 4)
		{
			
			if($model->update(false) !== false)
			{
				self::updateAllTopup($id,1);
				//var_dump($model);exit;
				$model->action =$model->action_before;
				$model->save();
				
				Yii::$app->session->setFlash('success', "Undo success");
	    		 return $this->redirect(['index']);
			}
			else{
				Yii::$app->session->setFlash('warning', "Fail to undo");
			}
				
			return $this->redirect(['direct']);
		}
	}

	public function actionEdit($id)
	{
		// Cancel function incomplete
		$model = OfflineTopup::find()->where('id = :id',[':id' => $id])->one(); 
		//var_dump($model->load(Yii::$app->request->post())); exit;
		if ($model->action == 1 ){
			
			if($model->load(Yii::$app->request->post()))
			{
			
			//var_dump($model->update()); exit;
			//$model->action =4;
		//	$model->inCharge = Yii::$app->user->identity->adminname;
			$model->inCharge = Yii::$app->user->identity->id;
			//var_dump($model->inCharge); exit; 
			$model->save();
			
			Yii::$app->session->setFlash('success', "Update success");
    		 return $this->redirect(['index']);
			}
			    		
		return $this->render('update', ['model' => $model]);

		}
		elseif ($model->action !=1){
		
		Yii::$app->session->setFlash('error', "Action failed!");
		}
		
		
		return $this->redirect(['direct']);
	}

    public function actionDirect()
    {
	  
	   $searchModel = new OfflineTopup();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams,Yii::$app->request->post('action'));
		$list = ArrayHelper::map(OfflineTopupStatus::find()->all() ,'title' ,'title');
		
       return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel,'list'=>$list]);
    }
	
	protected static function updateAllTopup($id,$status)
	{
		$data = self::updOfflineTopupStatus($id,$status);
		$operate = OfflineTopupOperateController::createOperate($id,$status,1);
		//var_dump($data->validate() && $operate->validate());exit;
		//var_dump($status);exit;
		if(is_null($data) || is_null($operate))
    	{
    		return false;
    	}
       
    	$isValid = $data->validate() && $operate->validate();
	 
    	if($isValid)
    	{
    		$data->save();
    		$operate->save();
			return true;
			
    	}
    	else
    	{
    		return false;
    	}
    	return false;
			
	}
		
	protected static function updOfflineTopupStatus($id,$status)
    {
    	$data = OfflineTopup::findOne($id);

    	if(is_null($data))
    	{
    		return $data;
    	}
        $statusDesription = OfflineTopupStatusController::getStatusType($status,1);
        $data->action =  $statusDesription;
    	return $data;
    }
	  
	protected function findModel($id)
    {
        if (($model = OfflineTopup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionViewOperate($tid)
	{
		$model =  OfflineTopupOperate::find()->where(['tid' => $tid]);

		$dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
	        'defaultOrder' => 
		        [
		            'updated_at' => SORT_DESC,
		        ]
	    	],
        ]);
		     
		return $this->render('view',['model' => $dataProvider ,'tid' => $tid]);
	}
	
}
