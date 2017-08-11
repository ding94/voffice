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

		$statusName = ParcelStatusNameController::getStatusType($status,2);
		$operate = new ParcelOperate;

		$operate->adminname = Yii::$app->user->identity->adminname;
    	$operate->parid = $parid;
    	$operate->oldVal = $old;
		$operate->newVal = $statusName;
    	
    	return $operate;
	}
}