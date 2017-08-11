<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User\User;
use yii\filters\AccessControl;
use common\models\User\UserDetails;
use common\models\User\UserCompany;
use common\models\User\UserActualContact;
use common\models\User\UserBalance;
use common\models\User\UserLogin;
use common\models\OfflineTopup;
use kartik\mpdf\Pdf;

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
					   Yii::$app->session->setFlash('success', 'Update Successful');
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
				   Yii::$app->session->setFlash('success', 'Update Successful');
				   return $this->redirect(['index']);
				}
			}
		}
		$this->view->title = 'Update Profile';
		$this->layout = 'user';
		return $this->render("useredit",['model' => $model]);

	}

	public function actionChangepassword()
 	{      
	    $model = new UserLogin;
	 
	     if($model->load(Yii::$app->request->post()) ){
	 		if ($model->check()) {
	 			 Yii::$app->session->setFlash('success', 'successfully changed password');
	 			    return $this->redirect(['index']);
	 		}
	     
	         
	         else {
	         	Yii::$app->session->setFlash('warning', 'changed password failed');
	            
	         }
	      
	     }
	    $this->view->title = 'Change Password';
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
				   Yii::$app->session->setFlash('success', 'Update Successful');
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
				   Yii::$app->session->setFlash('success', 'Update Successful');
				   return $this->redirect(['usercompany']);
				}
			}
		}
		$this->view->title = 'Update Company Info';
		$this->layout = 'user';
		return $this->render('usercompanyedit', ['model' => $model]);
 	}

 	public function actionUsermailingaddress()
 	{
 		$model = UserActualContact::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
 		if (empty($model)) 
 		{
 			$model = new UserActualContact();
 		}

 		$this->layout = 'user';
		return $this->render('usermailingaddress', ['model' => $model]);
 	}

 	public function actionUsermailingaddressedit()
 	{
 		$model = UserActualContact::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
 		
 		if (empty($model))
 		{
 			$model = new UserActualContact();
 			$model->setScenario('mailingAddress');
			if(Yii::$app->request->isPost)
			{
				$post = Yii::$app->request->post();
				if($model->add($post))
				{
				   Yii::$app->session->setFlash('success', 'Update Successful');
				   return $this->redirect(['usermailingaddress']);
				}
			}
		}
		else
		{
			$model = UserActualContact::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
			$model->setScenario('mailingAddress');
			if(Yii::$app->request->isPost)
			{
				$post = Yii::$app->request->post();
				if($model->add($post))
				{
				   Yii::$app->session->setFlash('success', 'Update Successful');
				   return $this->redirect(['usermailingaddress']);
				}
			}
		}
		$this->view->title = 'Update User Mailing Address';
		$this->layout = 'user';
		return $this->render('usermailingaddressedit', ['model' => $model]);
 	}

 	public function actionUserbalance()
 	{
 		$model = UserBalance::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
 		$offlinetopup = OfflineTopup::find()->where('username = :username' ,[':username' => Yii::$app->user->identity->username])->one();
 		if (empty($model)) 
 		{
 			$model = new UserBalance();
 		}

 		$this->layout = 'user';
		return $this->render('userbalance', ['model' => $model,'offlinetopup' => $offlinetopup]);
 	}

 	public function actionRejectreason()
 	{
 		$model = OfflineTopup::find()->where('username = :username' ,[':username' => Yii::$app->user->identity->username])->orderBy(['id' => SORT_DESC])->one();
 		if (empty($model)) 
 		{
 			$model = new OfflineTopup();
 		}

 		$this->layout = 'user';
 		return $this->renderPartial('rejectreason',['model' => $model]);
 	}

 	/*
	*Action function to generate pdf from html view. 
	*Just sample.
 	*/
 	public function actionSamplePdf()
 	{
 		$user = User::find()->where('id = :id' ,[':id' => Yii::$app->user->identity->id])->one();
 		$model = UserDetails::find()->where('uid = :uid'  , [':uid' => Yii::$app->user->identity->id])->one();
 		$pdf = new Pdf([
 			'mode' => Pdf::MODE_CORE,
 			'content' => $this->render('useredit',['user' => $user,'model' => $model]),
 			'options' => [
 				'title' => 'Sample Only',
 				'subject' => 'Sample Subject',
 			],
 			'methods' => [
 				'SetHeader' => ['Generated By VOFFICE'],
 				'SetFooter' => ['|Page{PAGENO}|'],
 			]
 			]);
 		return $pdf->render();
 	}

}
