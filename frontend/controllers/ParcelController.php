<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelSearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;


class ParcelController extends \yii\web\Controller
{
    //public $myvariable;

    public function actionIndex()
    {
        $searchModel = new ParcelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	$this->layout = 'user';
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel,]);
    }

    public function actionNewParcel()
    {
        $searchModel = new UserParcel();
        $dataProvider = $searchModel->searchnewparcel(Yii::$app->request->queryParams);

        $this->layout = 'user';
        return $this->render('newparcel', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionSentParcel()
    {
        $searchModel = new UserParcel();
        $dataProvider = $searchModel->searchsentparcel(Yii::$app->request->queryParams);

        $this->layout = 'user';
        return $this->render('sentparcel', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionReceivedParcel()
    {
        $searchModel = new UserParcel();
        $dataProvider = $searchModel->searchreceivedparcel(Yii::$app->request->queryParams);

        $this->layout = 'user';
        return $this->render('receivedparcel', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

}
