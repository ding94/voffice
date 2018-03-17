<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use backend\controllers\CommonController;
use backend\modules\logistics\controllers\ParcelStatusNameController;
use common\models\Parcel\ParcelOperate;

Class ParcelOperateController extends CommonController
{
	/*
	 * list all operate that parcel done without search
	 */
	public function actionViewOperate($parid)
	{
		$model =  ParcelOperate::find()->where(['parid' => $parid]);

		$dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
	        'defaultOrder' => 
		        [
		            'updated_at' => SORT_DESC,
		        ]
	    	],
        ]);

		return $this->render('view',['model' => $dataProvider ,'parid' => $parid]);
	}

	/*
	 * create new operate
	 */

	public static function createOperate($parid,$status,$type)
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
		$operate->operatorType = 1;
		$operate->operatorID = Yii::$app->user->identity->id;
    	$operate->parid = $parid;
    	$operate->oldVal = $old;

		if($type == 1)
		{
			$statusName = ParcelStatusNameController::getStatusType($status,2);
			$operate->newVal = $statusName;
			$operate->type = "Status";
		}
		elseif($type == 2)
		{
			$operate->newVal = "Update address";
			$operate->type = "Data";
		}
    	
    	return $operate;
	}
}