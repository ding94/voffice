<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\UserContact;
use yii\filters\AccessControl;
use common\models\UserDetails;
use common\models\UserCompany;

class UserController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
		$user = User::find()->where('id = :id' ,[':id' => Yii::$app->user->identity->id]);
		if (empty($user)) {
			return $this->render('site/login', [
                'model' => $model,
            ]);
		}

		$user = User::find()->where('id = :id' ,[':id' => Yii::$app->user->identity->id])->one();
		$userdetails = UserDetails::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();

    	$this->layout = 'user';
        return $this->render('index', ['user' => $user, 'userdetails' => $userdetails]);
    }

    public function actionUseredit()
	{
		$userid = User::find()->where('id = :id' ,[':id' => Yii::$app->user->identity->id])->one();
		$model = UserDetails::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
		if(empty($model))
			{
			$model = new UserDetails;
			if(Yii::$app->request->isPost)
			{
				$post = Yii::$app->request->post();
				if($model->add($post))
				{
				   Yii::$app->session->setFlash('success', "Update Successful");
				   return $this->redirect(['index']);
				}
			}
			}
		else
		{
			$model = UserDetails::find()->where('uid = :uid'  , [':uid' => Yii::$app->user->identity->id])->one();
			if(Yii::$app->request->isPost)
			{
				$post = Yii::$app->request->post();
				if($model->add($post))
				{
				   Yii::$app->session->setFlash('success', "Update Successful");
				   return $this->redirect(['index']);
				}
			}
			}
		$this->layout = 'user';
		return $this->render("useredit",['model' => $model]);

	}

	public function actionChangepassword()
 	{      
	    $model = new User;
	 
	    $model = User::find()->where('id = :id' ,[':id' => Yii::$app->user->identity->id])->one();
	    $model->setScenario('changePwd');
	 
	 
	     if(isset($_POST['User'])){
	 
	        $model->attributes = $_POST['User'];
	        $valid = $model->validate();
	 
	        if($valid){
	 
	          $model->password = md5($model->new_password);
	 
	          if($model->save()){
	          	 Yii::$app->session->setFlash('success', "successfully changed password");
	             return $this->redirect('index');
	         }
	          else {
	             return $this->redirect('index');
	          }
	            }
	        }
	 	$this->layout = 'user';
	    return $this->render('changepassword',['model'=>$model]); 
 	}

 	public function actionUsercompany()
 	{
 		$model = UserCompany::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();

 		if (empty($model))
 		{
 			$model = new UserCompany();
 		}

 		$this->layout = 'user';
        return $this->render('usercompany', ['model' => $model]);
 	}

 	public function actionUsercompanyedit()
 	{
 		$model = UserCompany::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();

 		if (empty($model))
 		{
 			$model = new UserCompany();
			if(Yii::$app->request->isPost)
			{
				$post = Yii::$app->request->post();
				if($model->add($post))
				{
				   Yii::$app->session->setFlash('success', "Update Successful");
				   return $this->redirect(['usercompany']);
				}
			}
		}
		else
		{
			$model = UserCompany::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
			if(Yii::$app->request->isPost)
			{
				$post = Yii::$app->request->post();
				if($model->add($post))
				{
				   Yii::$app->session->setFlash('success', "Update Successful");
				   return $this->redirect(['usercompany']);
				}
			}
		}

		$this->layout = 'user';
		return $this->render('usercompanyedit', ['model' => $model]);
 	}

}
