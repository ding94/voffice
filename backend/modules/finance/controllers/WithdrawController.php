<?php

namespace backend\modules\finance\controllers;
use common\models\UserWithdraw;
use yii\data\ActiveDataProvider;
use Yii;


class WithdrawController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new UserWithdraw();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,0);
 
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
		//return $this->render('index');
    }

}
