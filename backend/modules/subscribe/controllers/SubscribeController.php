<?php

namespace backend\modules\subscribe\controllers;
use common\models\User\UserPackage;
use yii\data\ActiveDataProvider;
use Yii;

class SubscribeController extends \yii\web\Controller
{
    public function actionIndex()
    {
       $searchModel = new UserPackage();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index' ,['model' => $dataProvider , 'searchModel' => $searchModel]);
    }

}
