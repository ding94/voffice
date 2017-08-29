<?php

namespace backend\modules\finance\controllers;
use common\models\UserWithdraw;
use yii\data\ActiveDataProvider;
use Yii;


class WithdrawController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new UserWithdraw();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,0);
 
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
		//return $this->render('index');
    }
	
	public function actionApprove($id)
	{
			$model = $this->findModel($id);
			if($model->update(false) !== false)
			{
				$balance->save();
			//	self::updateAllTopup();
				Yii::$app->session->setFlash('success', "Update success");
			}
			else{
				Yii::$app->session->setFlash('error', "Fail to Update");
			}
		
	}

}
