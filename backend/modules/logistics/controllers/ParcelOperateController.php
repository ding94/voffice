<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use backend\controllers\CommonController;
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

		$operate = new ParcelOperate;

		$operate->adminname = Yii::$app->user->identity->adminname;
    	$operate->parid = $parid;
    	
    	switch ($status) {
    		case 0:
    			$operate->newVal = "Add new parcel";
    			break;
    		case 1:
    			$operate->oldVal = $oldOperate->newVal;
    			$operate->newVal = "Pending Pick Up";
    			break;

    		case 2:
    			$operate->oldVal = $oldOperate->newVal;
    			$operate->newVal = "Seding";
    			break;

    		default:
    			
    			break;
    	}
    	return $operate;
	}
}