<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelSearch;
use common\models\Parcel\ParcelOperate;
use common\models\Parcel\ParcelStatus;
use backend\modules\logistics\controllers\ParcelStatusNameController;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;


class ParcelController extends \yii\web\Controller
{
    //public $myvariable;

    public function actionIndex()
    {
        $searchModel = new ParcelSearch();
        $dataProvider = $searchModel->searchparceldetail(Yii::$app->request->queryParams,Yii::$app->user->identity->id);
        $status = Parcel::find()->where('uid = :uid' ,[':uid' =>Yii::$app->user->identity->id])->all();

    	$this->layout = 'user';
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'status'=>$status]);
    }

	public function actionView($parid)
	{
		$model =  ParcelDetail::find()->where(['parid' => $parid])->one();

		return $this->renderPartial('view',['model' => $model]);
	}

    public function actionEarlypostal($id,$status)
    {
        $parcel = Parcel::find()->where('id = :id',[':id' => $id])->one();
        $parcelstatus = ParcelStatus::find()->where('parid = :parid',[':parid' => $id])->one();
        $parcelstatus->prestatus = $status;
        $parcelstatus->status = 5;
        $parcel->status = 5;
        $parceloperate = self::createOperate($id,5);
        $parcel->save();
        $parcelstatus->save();
        $parceloperate->save();
        if($parcel->save() == true && $parcelstatus->save() == true)
        {
            Yii::$app->session->setFlash('success', "Early Postal Confirmed");
        }
        else
        {
            Yii::$app->session->setFlash('warning', "Fail Update");
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionConfirmreceived($id,$status)
    {
        $parcel = Parcel::find()->where('id = :id',[':id' => $id])->one();
        $parcelstatus = ParcelStatus::find()->where('parid = :parid',[':parid' => $id])->one();
        $parcelstatus->prestatus = $status;
        $parcelstatus->status = 4;
        $parcel->status = 4;
        $parceloperate = self::createOperate($id,4);
        $parcel->save();
        $parcelstatus->save();
        $parceloperate->save();
        if($parcel->save() == true && $parcelstatus->save() == true)
        {
            Yii::$app->session->setFlash('success', "Confirm Received");
        }
        else
        {
            Yii::$app->session->setFlash('warning', "Fail Update");
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public static function createOperate($parid,$status)
    {
        $oldOperate = ParcelOperate::find()->where('parid = :id' ,[':id' => $parid])->orderBy('updated_at DESC')->one();

        if(empty($oldOperate))
        {
            $old = "";
        }
        else
        {
            $old = $oldOperate->newVal;
        }

        $operate = new ParcelOperate;
        $operate->operatorType = 2;
        $operate->operatorID = Yii::$app->user->identity->id;
        $operate->parid = $parid;
        $operate->oldVal = $old;

        $statusName = ParcelStatusNameController::getStatusType($status,2);
        $operate->newVal = $statusName;
        $operate->type = "Status";

        
        return $operate;
    }
}
