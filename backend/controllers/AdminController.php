<?php

namespace backend\controllers;

use yii\web\Controller;
use backend\models\Admin;
use backend\models\AdminControl;
use backend\models\AdminResetPasswordForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

Class AdminController extends CommonController
{
	/**
     * Displays admin homepage.
     *
     * @return string
     */

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
		//var_dump($model);exit;
		$list = self::getRole(1);
		
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
		
		$listData = self::getRole(1);
		$role = self::getRole(2,$id);
		
		$list = array_merge($role,$listData);

		if($model->load(Yii::$app->request->post()) && $model->save())
		{
			$post = Yii::$app->request->post('Admin');
			
	        $validate = self::permission($post['role'],$id);

	        if($validate == true)
	        {
	        	Yii::$app->session->setFlash('success', "Update completed");
	        }
	        else
	        {
	        	Yii::$app->session->setFlash('warning', "Fail Update");
	        }
		
    		return $this->redirect(['index']);
		}
		return $this->render('addEdit', ['model' => $model ,'list' => $list]);
	}

	public static function permission($role,$id)
	{
		$auth = \Yii::$app->authManager;
		$item = $auth->getRole($role);
		$item = $item ? : $auth->getPermission($role);
		$auth->revoke($item,$id);

		$authorRole = $auth->getRole($role);
        if($auth->assign($authorRole, $id))
        {
        	return true;
        }
        return false;

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
			Yii::$app->session->setFlash('warning', "Fail to delete");
		}
       return $this->redirect(Yii::$app->request->referrer);
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
			Yii::$app->session->setFlash('warning', "Fail to Active");
		}
        return $this->redirect(['index']);

	}

	public function actionChangepass($id)
	{
		$model = new AdminResetPasswordForm();

		//detect whether current user id is current user session id
		if((int)$id !==  Yii::$app->user->identity->id)
		{
			Yii::$app->session->setFlash('warning', "Wrong access format");
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

	/*
	* get auth role
	* 1=> get all Role
	* 2=> get current id Role
	*/
	protected static function getRole($type,$id=0)
	{
		$auth = \Yii::$app->authManager;
		$data = "";
		switch ($type) {
			case 1:
				$data = $auth->getRoles();
				break;
			case 2:
				$data = $auth->getRolesByUser($id);
				break;
			default:
				break;
		}
	
		$list = ArrayHelper::map($data,'name','name');
        return $list;
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
