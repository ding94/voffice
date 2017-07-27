<?php 

namespace backend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\auth\AuthAssignment;
use Yii;

Class AuthController extends Controller
{
	public function behaviors()
    {
        return [
			'access' => [
			    'class' => AccessControl::className(),
			        'rules' => [
			            [
			                'allow' => true,
			                'roles' =>['super admin'],
			        	],
			    ],
			]          
        ];
    }

	public function actionIndex()
	{
		$searchModel = new AuthAssignment();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}
}