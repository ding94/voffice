<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\models\Parcel\ParcelStatusName;

Class ParcelStatusNameController extends Controller
{
	/*
	 * get statusName by type
	 * 1=> get id
	 * 2=> get showName
	 * 3=> get description name
	 */
	public static function getStatusType($id,$type)
	{
		$data = self::getStatus($id);
		switch ($type) {
			case 1:
				$value = $data->id;
				break;
			case 2:
				$value = $data->description;
				break;
			default:
				$value="";
				break;
		}
		return $value;
	}

	public static function listStatus()
	{
		$data = ArrayHelper::map(ParcelStatusName::find()->all(),'id','description');
		return $data;
	}

	protected static function getStatus($id)
	{
		if (($data = ParcelStatusName::findOne($id)) !== null) {
            return $data;
        } else {
           return false;
        }
	}
}