<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\models\User\UserSearch;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\ParcelOperate;
use common\models\Parcel\ParcelStatus;
use common\models\Parcel\ParcelSearch;

use common\models\User\User;

/**
 * Default controller for the `parcel` module
 */
Class ParcelController extends Controller
{
    public function actionReceivedMail()
    {
    	$searchModel = new UserSearch;
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
    }

    public function actionAddMail($id)
    {
    	$list = [[ 'type' => 1 , 'name' => 'Mail' ],[ 'type' => 2 , 'name' => 'Parcel']];
    	$listOfType = ArrayHelper::map($list, 'type', 'name');
    	$parcel = new Parcel;
    	$detail = new ParcelDetail;

    	return $this->render('add',['parcel'=> $parcel,'detail' => $detail ,'list' => $listOfType ,'id' => $id]);
    }

    /*
    *mutiple model save
    *one fail all reject
    */

    public function actionAddValidate($id)
    {
    	$username = User::find()->where('id =:id',[':id'=>$id])->one()->username;

    	$parcel =new Parcel;
    	$detail = new ParcelDetail;
    	$operate = new ParcelOperate;
    	$status = new ParcelStatus;

    	$parcel->load(Yii::$app->request->post());
    	$detail->load(Yii::$app->request->post());
    	$operate->load(Yii::$app->request->post());


    	$parcel->uid = $id;
    	$parcel->status = $parcel::PENDING;
    	$isValid = $parcel->validate();
    	if($isValid)
    	{
    		$parcel->save();

    		$parid = $parcel->id;
    		$detail->parid = $parid;
    		$operate->parid =  $parid;
    		$status->parid = $parid;

    		$operate->adminname = Yii::$app->user->identity->adminname;
    		$operate->newVal = "Add ".$username." parcel";

    		$status->status = $parcel::PENDING;
    		$status->updated_at = time();

    		$isValid = $operate->validate() && $operate->validate() && $status->validate();
    		
    		if($isValid)
    		{
    			$detail->save();
    			$operate->save();
    			$status->save();
    			Yii::$app->session->setFlash('success', "Add complted");
    		}
    		else
    		{
    			Parcel::deleteAll('id = :id', [':id' => $parid]);
    			Yii::$app->session->setFlash('warning', "Fail add");
    		}
    	}
    	else
    	{
    		Yii::$app->session->setFlash('warning', "Fail add");
    	}
		
		
		return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionTypeMail($id)
    {
    	$searchModel = new ParcelSearch;
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

    	return $this->render('mail',['model' => $dataProvider , 'searchModel' => $searchModel]);

    }
}
