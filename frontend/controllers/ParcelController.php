<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelSearch;
use common\models\Parcel\ParcelOperate;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;


class ParcelController extends \yii\web\Controller
{
    //public $myvariable;

    public function actionIndex()
    {
        $searchModel = new ParcelSearch();
        $dataProvider = $searchModel->searchparceldetail(Yii::$app->request->queryParams);

    	$this->layout = 'user';
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel,]);
    }
	public function actionView($parid)
	{
		$model =  ParcelDetail::find()->where(['parid' => $parid])->one();

		return $this->renderPartial('view',['model' => $model]);
	}
}
