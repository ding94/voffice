<?php

namespace frontend\controllers;
use common\models\OfflineTopup\OfflineTopup;
use common\models\OfflineTopup\OfflineTopupStatus;
use common\models\User\User;
use common\models\Upload;
use common\models\BankDetails;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;

class TopupHistoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new OfflineTopup();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,5);
	    $list = ArrayHelper::map(OfflineTopupStatus::find()->all() ,'title' ,'title');
		$name=ArrayHelper::map(BankDetails::find()->all() ,'id' ,'bank_name');
		//var_dump($name);exit;
		$this->layout = 'user';
	    return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel , 'list'=>$list,'name'=>$name]);
    }

}
