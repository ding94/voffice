<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelSearch;
use common\models\Parcel\ParcelOperate;
use common\models\Parcel\ParcelStatus;
use common\models\Parcel\ParcelStatusName;
use backend\modules\logistics\controllers\ParcelStatusNameController;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class ParcelController extends \yii\web\Controller
{
    //public $myvariable;


    public function actionIndex($status = "")
    {   

        $countParcel = $this->getTotalParcel();
        $searchModel = new ParcelSearch();
        $searchModel->status = $status;
        $label =  ParcelStatusName::find()->where('id = :id' ,[':id' =>$status])->one();
        if(!empty($label)){
            $title = $label->description;
        }else{
            $title= "All";
        };

        $dataProvider = $searchModel->searchparceldetail(Yii::$app->request->queryParams,Yii::$app->user->identity->id);
        $query = Parcel::find()->where('uid = :uid' ,[':uid' =>Yii::$app->user->identity->id])->orderBy(['id'=>SORT_DESC]);

        $statusid = ArrayHelper::map(parcelStatusName::find()->all(),'description','id');

         $link = CommonController::createUrlLink(1);
    	$this->layout = 'user';
        return $this->render('index', ['title'=> $title,'dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'status' => empty($status) ? "All" : $status,'link'=> $link ,'countParcel'=>$countParcel,'statusid'=>$statusid]);

        
    }

    /*
    * count all parcel status parcel
    * if empty let it empty
    */
    public static function getTotalParcel()
    {
        $countParcel['Received Mail']['total'] = 0;
        $countParcel['Pending Pickup']['total'] = 0;
        $countParcel['Sending']['total'] = 0;   
        $countParcel['Confirm received']['total'] = 0;   
        $countParcel['Early postal']['total'] = 0;   
        $countParcel['Pending early pickup']['total'] = 0;   
      
        $query = parcel::find()->where('uid = :uname', [':uname'=>Yii::$app->user->identity->id])->all();
        foreach($query as $data)
        {
            switch ($data['status']) {

                case 1:
                    $countParcel['Received Mail']['total'] += 1;
                    break;

                case 2:
                    $countParcel['Pending Pickup']['total'] += 1;
                    break;

                case 3:
                    $countParcel['Sending']['total'] += 1;
                    break;

                case 4:
                    $countParcel['Confirm']['total'] += 1;
                    break;
                
                case 5:
                    $countParcel['Early postal']['total'] += 1;
                    break;

                case 6:
                    $countParcel['Pending early pickup']['total'] += 1;
                    break;

                default:
               
                    $status = parcel_status_name::find()->where('id=:id',[':id'=>$data['status']])->one()->type;
                    $countParcel[$status]['total'] += 1;
                    break;
            }
        }

        foreach($countParcel as $i=> $data)
        {
            $countParcel[$i]['total'] = $data['total'] == 0 ? "" : $data['total'];
        }
       
        return $countParcel;
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
