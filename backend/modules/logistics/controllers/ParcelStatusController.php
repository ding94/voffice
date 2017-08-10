<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelStatus;
use common\models\Parcel\ParcelStatusName;
use backend\controllers\CommonController;

Class ParcelStatusController extends CommonController
{
	/*
	 * update parcel status
	 */
	public static function updateStatus($id,$status)
	{
		$parcelStatus = ParcelStatus::find()->where('parid = :id' ,[':id' => $id])->one();

		if(is_null($parcelStatus))
		{
			return $parcelStatus;
		}

		$parcelStatus->prestatus = $parcelStatus->status;
    	$parcelStatus->updated_at = time();

    	 $statusName = ParcelStatusName::findOne($status);
        $parcelStatus->status =  $statusName->id;

    	return $parcelStatus;
	}

	public static function newStatus($parid)
	{
		$data = new ParcelStatus;
		$data->status = Parcel::PENDING;
		$data->parid = $parid;
		$data->updated_at = time();
		return $data;
	}
}