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
use common\models\Parcel\ParcelStatusName;
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

    public function actionTypeMail($type)
    {
    	$searchModel = new ParcelSearch;
    	$searchModel->titlename = ParcelStatusName::find()->where('id = :id',[':id'=>$type])->one()->description;

    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$type);

    	return $this->render('mail',['model' => $dataProvider , 'searchModel' => $searchModel]);

    }

    public function actionNextStep($id,$status)
    {	
    	$data = $this->findModel($id);
    	$validate = self::changeParcelStatus($id,$status,$data);
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
     * Based on status and parcel id to change
     */
    public static function changeParcelStatus($id,$status,$data)
    {

    	$parcelStatus = ParcelStatus::find()->where('parid = :id' ,[':id' => $id])->one();
    	$oldOperate = ParcelOperate::find()->where('parid = :id' ,[':id' => $id])->orderBy('updated_at DESC')->one();

    	$parcelStatus->prestatus = $parcelStatus->status;
    	$parcelStatus->updated_at = time();

    	$operate = new ParcelOperate;

    	$operate->adminname = Yii::$app->user->identity->adminname;
    	$operate->parid = $id;
    	
    	switch ($status) {
    		case 1:
    			$data->status = Parcel::PENDING_PICK_UP;

    			$parcelStatus->status = Parcel::PENDING_PICK_UP;

    			$operate->oldVal = $oldOperate->newVal;
    			$operate->newVal = "Pending Pick Up";

    			break;
    		case 2:
    			$data->status = Parcel::SENDING;

    			$parcelStatus->status = Parcel::SENDING;

    			$operate->oldVal = $oldOperate->newVal;
    			$operate->newVal = "Seding";
    		default:
    			
    			break;
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

    protected function findModel($id)
    {
        if (($model = Parcel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
