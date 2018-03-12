<?php

namespace frontend\controllers;
use common\models\UserWithdraw;
use common\models\BankDetails;
use common\models\User\User;
use common\models\OfflineTopup\OfflineTopupStatus;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

class WithdrawHistoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $searchModel = new UserWithdraw();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,0);

		$list = ArrayHelper::map(OfflineTopupStatus::find()->all() ,'title' ,'title');
		$name=ArrayHelper::map(BankDetails::find()->all() ,'id' ,'bank_name');
        $this->layout = 'user';
		return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel, 'list'=>$list ,'name'=>$name]);
    }

}
