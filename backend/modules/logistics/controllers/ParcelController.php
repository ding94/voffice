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

    public function actionAddValidate($id)
    {

    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$parcel =new Parcel;
    		$detail = new ParcelDetail;
    		$operate = new ParcelOperate;

    		$parcel->uid = $id;
    		$parcel->status = 1;
			$parcel->save();
           
			$detail->parid = $parcel->id;
			$detail->save();
			
			$operate->parid = $parcel->id;
			$operate->adminname = Yii::$app->user->identity->adminname;
			$operate->newVal = "Add".$id."parcel";
			$operate->save();

			$transaction->commit();
		} catch (Exception $e) {
			Yii::$app->session->setFlash('warning',$e);
			$transaction->rollBack();
		}

		return $this->redirect(Yii::$app->request->referrer);
    }
}
