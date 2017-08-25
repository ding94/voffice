<?php

namespace frontend\controllers;
use common\models\User\User;
use common\models\UserWithdraw;
use common\models\BankDetails;
use Yii;

use yii\helpers\ArrayHelper;
class WithdrawController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new UserWithdraw;
    	//$upload = new Upload;
    	
		$items = ArrayHelper::map(BankDetails::find()->all(), 'bank_name', 'bank_name');
		//var_dump(Yii::$app->user->identity->id);exit;
    	if(Yii::$app->request->post())
    	{
    		$post = Yii::$app->request->post();
    		//$model->username = User::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->username;
    		$model->uid = Yii::$app->user->identity->id;
    		$model->load($post);
			
			if($model->save())
			{
				Yii::$app->session->setFlash('success', 'Upload Successful');
			}
			else
			{
				Yii::$app->session->setFlash('fail', 'Upload Fail');
			}
    	}
		$this->layout = 'user';
    	return $this->render('index' ,['model' => $model,'items'=>$items]);
    }

}
