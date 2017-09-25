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
use common\models\User\UserVoucher;
use common\models\User\UserLogin;
use common\models\User\UserPackage;
use common\models\User\Package;
use common\models\User\UserPackageSubscription;
use common\models\OfflineTopup\OfflineTopup;
use common\models\SubscribeType;
use common\models\News;
use kartik\mpdf\Pdf;
use frontend\controllers\SubscribeController;
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
 		$offlinetopup = OfflineTopup::find()->where('uid= :uid' ,[':uid' => Yii::$app->user->identity->username])->one();
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

 	public function actionUservouchers()
 	{
 		$searchModel = new UserVoucher();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 		$model = UserVoucher::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
 		$this->layout = 'user';
 		return $this->render('uservouchers',['model' => $model, 'dataProvider' => $dataProvider , 'searchModel'=> $searchModel]);
 	}

 	/*
	*Action function to generate pdf from html view. 
	*Just sample.
 	*/
 	public function actionSamplePdf()
 	{
 		$user = User::find()->where('id = :id' ,[':id' => Yii::$app->user->identity->id])->one();
 		$userdetails = UserDetails::find()->where('uid = :uid'  , [':uid' => Yii::$app->user->identity->id])->one();
 		
 		$pdf = new Pdf([
 			'mode' => Pdf::MODE_CORE,
 			'content' => $this->renderPartial('index',['user' => $user,'userdetails' => $userdetails]),
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

	public function actionUserpackage()
 	{
 		$model = Userpackage::find()->joinWith('package')->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
		if(empty($model)){
			$model = new Userpackage();
			//$model->type = 1;
			$model->save();
		}
 		$offlinetopup = OfflineTopup::find()->where('uid = :id',[':id' => $model->uid])->one(); 
 		//var_dump($offlinetopup);exit;
		$subscribetype = SubscribeType::find()->where(['id'=>$model->type])->one();

		if(!empty($model->type)){
					$subscribetype = SubscribeType::find()->where(['id'=>$model->type])->one()->description;
		}
		$nextpayment =  UserPackageSubscription::find()->all();
		//$model->end_period = date('Y-m-d h:i:s',strtotime('-330 days',strtotime($model->end_period)));
		$userpackagesubscription= UserPackageSubscription::find()->where(['uid' => $model->uid])->one();
		//var_dump($userpackagesubscription); exit;
		//var_dump($subscribetype);exit;
		if (empty($model)) 
 		{
 			$model = new UserPackage();
 		}

 		$this->layout = 'usertest';
		return $this->render('userpackage', ['model' => $model,'userpackagesubscription'=>$userpackagesubscription,'subscribetype'=>$subscribetype]);
 	}
	
	public function actionPackage()
    {
        return $this->render("../package/index");
    }
	
	public function actionUserpackagesubscribe()
	{
		return $this->render("../user/userpackage");
	}

	public function actionNews($id)
	{
		$model=News::find()->orderBy('id DESC')->all();
		$news=News::find()->where('id = :id',[':id' => $id])->one();
		return $this->render('usernews',['model'=>$model,'id'=>$id,'news'=>$news]);
	}
}
