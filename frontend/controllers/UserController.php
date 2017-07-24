<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\UserContact;
use yii\filters\AccessControl;

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
		$usercontact = UserContact::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();

    	$this->layout = 'user';
        return $this->render('index', ['user' => $user, 'usercontact' => $usercontact]);
    }

    public function actionUseredit()
	{
		$userid = User::find()->where('id = :id' ,[':id' => Yii::$app->user->identity->id])->one();
		$model = UserContact::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
		if(empty($model))
			{
			$model = new UserContact;
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
			$model = UserContact::find()->where('uid = :uid'  , [':uid' => Yii::$app->user->identity->id])->one();
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

}
