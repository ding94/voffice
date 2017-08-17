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
use backend\controllers\CommonController;
use backend\modules\logistics\controllers\ParcelOperateController;
use backend\modules\logistics\controllers\ParcelStatusController;
use backend\modules\logistics\controllers\ParcelDetailController;
use backend\modules\logistics\controllers\ParcelStatusNameController;


Class ParcelController  extends CommonController
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
    		$operate = ParcelOperateController::createOperate($parid,1);
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

    public function actionTypeMail($status)
    {
    	$searchModel = new ParcelSearch;
    	$searchModel->titlename = ParcelStatusNameController::getStatusType($status,2);

        $list = ParcelStatusNameController::listStatus();

    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$status);

    	return $this->render('mail',['model' => $dataProvider , 'searchModel' => $searchModel ,'list'=>$list , 'status' => $status]);

    }
		public static function getStatus($status){
			$value ="";
			switch ($status){
				case '1':
					$value = Parcel::PENDING_PICK_UP;
					break;
				case '2':
					$value = Parcel::SENDING;
					break;
				case '5':
					$value = Parcel::PENDING_EARLY;
					break;
				case '6':
					$value = Parcel::SENDING;
					break;
								
			}
		return $value;	
		}
    /*
     * change mail status to another status
     */

    public function actionNextStep($id,$status)
    {	
        if($status == 3 || $status == 4 )
        {
            Yii::$app->session->setFlash('warning', "Cannot process to next step");
            return $this->redirect(Yii::$app->request->referrer);
        }

        
		$nextStatus = self::getStatus($status);
		//var_dump($aa); exit;
    	$validate = self::updateAllParcel($id,$nextStatus);

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
	
	

    public function actionBatch()
    {
        $data = Yii::$app->request->post();
        if(empty($data['StatusChoice']) || empty($data['selection']))
        {
            Yii::$app->session->setFlash('warning', "Plese select one status or tick one");
            return $this->redirect(Yii::$app->request->referrer);
        }
        $status = $data['StatusChoice'];
      
        foreach($data['selection'] as $id)
        {
            self:: updateAllParcel($id,$status);
        }

        Yii::$app->session->setFlash('success', "Update completed");
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
        $statusDesription = ParcelStatusNameController::getStatusType($status,1);
        $data->status =  $statusDesription;
    	return $data;
    }
}
