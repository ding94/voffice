<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use common\models\Parcel\ParcelOperate;
use yii\data\ActiveDataProvider;

Class ParcelOperateController extends Controller
{
	public function actionViewOperate($id)
	{
		$model =  ParcelOperate::find()->where(['parid' => $id]);

		$dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
	        'defaultOrder' => 
		        [
		            'updated_at' => SORT_DESC,
		        ]
	    	],
        ]);

		return $this->render('view',['model' => $dataProvider ,'parid' => $id]);
	}
}