<?php

namespace backend\modules\finance\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use backend\controllers\CommonController;
use backend\modules\finance\controllers\OfflineTopupStatusController;
use common\models\OfflineTopup\OfflineTopupOperate;

Class OfflineTopupOperateController extends CommonController
{
	/*
	 * list all operate that parcel done without search
	 */
	

	/*
	 * create new operate
	 */

	public static function createOperate($tid,$status,$type)
	{
	
		$oldOperate = OfflineTopupOperate::find()->where('tid = :id' ,[':id' => $tid])->orderBy('updated_at DESC')->one();

		if(empty($oldOperate))
		{
			$old = "";
		}
		else
		{
			$old = $oldOperate->newVal;
		}

		$operate = new OfflineTopupOperate;
		$operate->adminid = Yii::$app->user->identity->id;
		//var_dump($operate->adminid);exit;
    	$operate->tid = $tid;
    	$operate->oldVal = $old;

		if($type == 1)
		{
			$statusName = OfflineTopupStatusController::getStatusType($status,2);
			$operate->newVal = $statusName;
			$operate->type = "Status";
			//var_dump($operate); exit;
		}
		elseif($type == 2)
		{
			$operate->newVal = "123";
			$operate->type = "Data";
		}
    	
    	return $operate;
	}
}