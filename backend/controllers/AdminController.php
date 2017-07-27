<?php

namespace backend\controllers;

use yii\web\Controller;
use backend\models\Admin;
use backend\models\AdminControl;
use backend\models\AdminResetPasswordForm;
use backend\models\auth\AuthItem;
use backend\models\auth\AuthAssignment;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

Class AdminController extends Controller
{
	/**
     * Displays admin homepage.
     *
     * @return string
     */

	public function behaviors()
    {
        return [
			'access' => [
			    'class' => AccessControl::className(),
			        'rules' => [
			            [
			            	'actions' => ['delete' ,'active'],
			                'allow' => true,
			                'roles' =>['super admin'],
			        	],
			        	[
			        		'actions' => ['index' , 'add' , 'update'],
 							'allow' => true,
			                'roles' =>['admin'],
			        	],
			        	[
			        	 	'actions' => ['changepass'],
			        		'allow' =>  true,
			        		'roles' => ['@'],
			        	]
			                   
			    ],
			]          
        ];
    }

	public function actionIndex()
	{

		$searchModel = new AdminControl();
		$searchModel->scenario ='searchAdmin';
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}

	public function actionAdd()
	{
		$model = new AdminControl();
		$model->scenario = 'addAdmin';
		$model->adminTittle = "Add Admin";
		$model->passwordOff = '1';

		$listData = new AuthItem();
		$list = $listData->roleList();
		
		if($model->load(Yii::$app->request->post()) && $model->add())
		{

			Yii::$app->session->setFlash('success', "Add completed");
    		return $this->redirect(['index']);
		}
		return $this->render('addEdit' ,['model' => $model ,'list' => $list]);
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->scenario = 'changeAdmin';
		$model->adminTittle = "Update Admin";
		$model->passwordOff = '0';

		$listData = new AuthItem();
		$role = New AuthAssignment();

		$list = array_merge($role->getAdminRole($id),$listData->roleList());

		if($model->load(Yii::$app->request->post()) && $model->save())
		{
			Yii::$app->session->setFlash('success', "Update completed");
    		return $this->redirect(['index']);
		}
		return $this->render('addEdit', ['model' => $model ,'list' => $list]);
	}

	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->status = 0;
		if($model->update(false) !== false)
		{
			Yii::$app->session->setFlash('warning', "Delete completed");
		}
		else{
			Yii::$app->session->setFlash('danger', "Fail to delete");
		}
        return $this->redirect(['index']);
	}

	public function actionActive($id)
	{
		$model = $this->findModel($id);
		$model->status = 10;
		if($model->update(false) !== false)
		{
			Yii::$app->session->setFlash('success', "Active completed");
		}
		else{
			Yii::$app->session->setFlash('danger', "Fail to Active");
		}
        return $this->redirect(['index']);

	}

	public function actionChangepass($id)
	{
		$model = new AdminResetPasswordForm();

		//detect whether current user id is current user session id
		if((int)$id !==  Yii::$app->user->identity->id)
		{
			Yii::$app->session->setFlash('danger', "Wrong access format");
			return $this->goBack();
		}
		if(Yii::$app->request->isPost)
		{
			$model->id = $id;
			if($model->load(Yii::$app->request->post()) && $model->changepass())
			{
				Yii::$app->session->setFlash('success', "Password change completed");	
			}
		}
		return $this->render('changepass' , ['model' => $model]);
	}

  	/**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
