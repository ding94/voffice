<?php

namespace frontend\controllers;
use common\models\User\User;
use common\models\UserWithdraw;
use common\models\BankDetails;
use common\models\User\UserBalance;
use Yii;
use yii\helpers\ArrayHelper;

class WithdrawController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new UserWithdraw;
    	//$upload = new Upload;
    	$balance = UserBalance::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
		
		$name = ArrayHelper::map(BankDetails::find()->all(), 'id', 'bank_name');
	
		//var_dump(Yii::$app->user->identity->id);exit;
    	if(Yii::$app->request->post())
    	{
    		$post = Yii::$app->request->post();
    		//$model->username = User::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->username;
    		$model->uid = Yii::$app->user->identity->id;
			$model->action = 1;
	
    		$model->load($post);
			//var_dump($model->withdraw_amount > $balance->balance);exit;
			if($model->withdraw_amount <= $balance->balance -2)
			{	
				$balance ->balance -= ($model->withdraw_amount+2);
				//var_dump($balance->save()); exit;
				self::actionValidation($model,$balance);
				Yii::$app->session->setFlash('success', 'Upload Successful');
				return $this->redirect(['withdraw/index']);
			}
			elseif($model->withdraw_amount > $balance->balance -2)
			{
				Yii::$app->session->setFlash('error', 'Withdraw amount exceed balance!');
			}
    	}
		$model->acc_name ="";
		$model->withdraw_amount ="";
		$model->to_bank ="";
		
		$this->layout = 'user';
    	return $this->render('index' ,['model' => $model,'name'=>$name,'balance'=>$balance]);
    }
	
	public function actionValidation($model,$balance)
	{
		if ($model->validate() && $balance->validate())
		{
				//var_dump($model);exit;
			$model->save();
			$balance->save();
		}
	}

}
