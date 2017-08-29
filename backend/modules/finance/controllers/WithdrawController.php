<?php

namespace backend\modules\finance\controllers;
use common\models\UserWithdraw;
use common\models\User\UserBalance;
use common\models\BankDetails;
use common\models\User\User;
use yii\data\ActiveDataProvider;
use common\models\OfflineTopup\OfflineTopupStatus;
use yii\helpers\ArrayHelper;
use Yii;


class WithdrawController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new UserWithdraw();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,0);
		$list = ArrayHelper::map(OfflineTopupStatus::find()->all() ,'title' ,'title');
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel, 'list'=>$list]);
		//return $this->render('index');
    }

	public function actionApprove($id)
	{
		//$model = $this->findModel($id);
		$model = UserWithdraw::find()->where('id = :id',[':id' => $id])->one(); 
		  $model->scenario = 'negative'; // set senario
		if ($model->action == 1)
		{
			$balance = self::deductBalance($model);
			
			$model->action = 3;
			$model->inCharge = Yii::$app->user->identity->adminname;
			//var_dump($balance); exit; 
			if($model->save(false) !== false)
			{
				$balance->save();
				Yii::$app->session->setFlash('success', "Approve success");
			}
			else{
				Yii::$app->session->setFlash('error', "Fail to approve");
			}
		}
		elseif ($model->action !=1){
			Yii::$app->session->setFlash('error', "Action Cancelled!");
		}
        return $this->redirect(['index']);
	}
	
	protected static function deductBalance($model)
	{
		$uid = UserWithdraw::find()->where('uid = :name',[':name'=>$model->uid])->one()->uid;
		
		$balance =UserBalance::find()->where('uid = :name',[':name'=>$uid])->one();
		$balance ->negative += $model->withdraw_amount;
		//$balance ->balance -= $model->withdraw_amount;
		
		return $balance;
	}
	public function actionCancel($id)
	{
		$model = UserWithdraw::find()->where('id = :id',[':id' => $id])->one(); 
		  //$model->scenario = 'negative';
		//var_dump($model->load(Yii::$app->request->post())); exit;
		if ($model->action == 1)
		{
						
				if($model->load(Yii::$app->request->post()))
			{
				$balance = self::addBalance($model);
				$model->action =4;
				$model->inCharge = Yii::$app->user->identity->adminname;
				$model->save();
				$balance->save();
				Yii::$app->session->setFlash('success', "Approve success");
				return $this->redirect(['index']);
			}
			return $this->render('update', ['model' => $model]);
		}
			else{
				Yii::$app->session->setFlash('error', "Fail to approve");
			}
			
				 return $this->redirect(['index']);
		}		
			
		
		protected static function addBalance($model)
	{
		$uid = UserWithdraw::find()->where('uid = :name',[':name'=>$model->uid])->one()->uid;
		
		$balance =UserBalance::find()->where('uid = :name',[':name'=>$uid])->one();
		//$balance ->negative += $model->withdraw_amount;
		$balance ->balance += $model->withdraw_amount;
		
		return $balance;
	}
			    		
		

		}
		
	

