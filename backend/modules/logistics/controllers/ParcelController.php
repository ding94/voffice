<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\models\User\UserSearch;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\ParcelSearch;
use common\models\Parcel\ParcelStatusName;
use common\models\User\User;
use backend\modules\logistics\controllers\ParcelOperateController;
use backend\modules\logistics\controllers\ParcelStatusController;
use backend\modules\logistics\controllers\ParcelDetailController;


Class ParcelController extends Controller
{
    public function actionReceivedMail()
    {
    	$searchModel = new UserSearch;
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
    }

    /*
    * show all that new mail require
    */

    public function actionNewMail($id)
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

    public function actionAddNewMail($id)
    {
    	$post = Yii::$app->request->post();

    	$username = User::find()->where('id =:id',[':id'=>$id])->one()->username;
    
    	$parcel = self::newParcel($id,$post);

    	$isValid = $parcel->validate();
    	if($isValid)
    	{
    		$parcel->save();

    		$parid = $parcel->id;
    		
    		$detail = ParcelDetailController::createDetail($parid,$post);
    		$operate = ParcelOperateController::createOperate($parid,0);
    		$status = ParcelStatusController::newStatus($parid);
    		
    		$isValid = $detail->validate() && $operate->validate() && $status->validate();
    		
    		if($isValid)
    		{
    			$detail->save();
    			$operate->save();
    			$status->save();
    			Yii::$app->session->setFlash('success', "Add completed");
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

    /*
     * based on mail status give the result to user
     */

    public function actionTypeMail($type)
    {
    	$searchModel = new ParcelSearch;
    	$searchModel->titlename = ParcelStatusName::find()->where('id = :id',[':id'=>$type])->one()->description;

    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$type);

    	return $this->render('mail',['model' => $dataProvider , 'searchModel' => $searchModel]);

    }

    /*
     * change mail status to another status
     */

    public function actionNextStep($id,$status)
    {	
    	$validate = self::updateAllParcel($id,$status);

    	if($validate == true)
    	{
    		Yii::$app->session->setFlash('success', "Update completed");
    	}
    	else
    	{
    		Yii::$app->session->setFlash('warning', "Fail Update");
    	}
    	return $this->redirect(Yii::$app->request->referrer);
    }

    /*
     * get all modidy data or new data
     */
    protected static function updateAllParcel($id,$status)
    {
    	$data = self::updParcelStatus($id,$status);

    	$parcelStatus = ParcelStatusController::updateStatus($id,$status);

    	$operate = ParcelOperateController::createOperate($id,$status);

    	if(is_null($data) || is_null($parcelStatus) || is_null($operate))
    	{
    		return false;
    	}

    	$isValid = $data->validate() && $parcelStatus->validate() && $operate->validate();

    	if($isValid)
    	{
    		$data->save();
    		$parcelStatus->save();
    		$operate->save();
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    	return false;
    }

    protected static function newParcel($id,$post)
    {
    	$parcel =new Parcel;
    	$parcel->load($post);
    	$parcel->uid = $id;
    	$parcel->status = $parcel::PENDING;
    	return $parcel;
    }	

    /*
     * update parcel status
     */

    protected static function updParcelStatus($id,$status)
    {
    	$data = Parcel::findOne($id);

    	if(is_null($data))
    	{
    		return $data;
    	}

    	switch ($status) {
    		case 1:
    			$data->status = Parcel::PENDING_PICK_UP;

    			break;
    		case 2:
    			$data->status = Parcel::SENDING;

    			break;
    		default:
    			
    			break;
    	}
    	return $data;
    }
}
