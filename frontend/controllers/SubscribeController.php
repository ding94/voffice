<?php

namespace frontend\controllers;
use common\models\Package;
use common\models\User\UserPackage;
use common\models\User\UserPackageSubscription;
use common\models\User\User;
use common\models\User\UserDetails;
use common\models\Payment;
use common\models\SubscribePackageHistory;
use common\models\SubscribeType;
use frontend\controllers\PaymentController;
use yii\helpers\ArrayHelper;
use Yii;

class SubscribeController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$subscribe = new UserPackage();

    	$items = ArrayHelper::map(SubscribeType::find()->where(['or',['id'=>2],['id'=>4],['id'=>5],['id'=>6]])->all(),'id','description');

    	$payment = new Payment();

    	return $this->render('index',['subscribe'=>$subscribe,'items'=>$items, 'payment'=>$payment]);
    }

    /*
     * detect user subscibe already or not
    */
    public function actionMakeSubscribe()
  	{
  		$available = self::availableSubscribe();
  		if($available == true)
  		{
  			Yii::$app->session->setFlash('warning', 'Already Subscribe');
  		}
  		else
  		{
  			self::processAll();
  		}
  		
  		return $this->redirect(['user/userpackage']);
  	}

  	/*
  	* get all the needed database validation
  	* save the payment and subscribe first to do subscirehistory
  	* if one fail all will cancel 
  	*/

  	protected static function processAll()
  	{
  		$currentDate = date('Y-m-d h:i:s');

  		$post= Yii::$app->request->post();
  		
  		$subscribeType = SubscribeType::findOne($post['UserPackage']['sub_period']);

  		$payment = PaymentController::makeSubscribePayment($post['Payment']['paid_amount'],$subscribeType['times']);

  		$subscribe = self::makeSubscribe($post['UserPackage'],$currentDate,$subscribeType['sub_period']);

  		$userbalance = PaymentController::getPaymentBalance($post['Payment']['paid_amount'],$subscribeType['times']);

  		$packageSubscribe = self::makePackageSubscribe($subscribeType['sub_period'],$subscribeType['next_payment']);
  		
  		$isValid = $payment->validate() && $subscribe->validate() && $packageSubscribe->validate() && $userbalance->validate();
  		
  		if($isValid)
  		{
  			$payment->save();
  			$subscribe->save();
  			$subscribeHistory = self::makeSubscribeHistory($subscribe,$payment);
  			if($subscribeHistory->save() && $userbalance->save() &&  $packageSubscribe->save())
  			{
  				self::makeEmail($packageSubscribe);
  				Yii::$app->session->setFlash('success', 'Subscribe Success');
  			}
  			else
  			{
  				Payment::deleteAll('id = :id' ,[':id' => $payment['id']] );
  				Subscribe::deleteAll('uid = :uid' ,[':uid' => Yii::$app->user->identity->id]);
  				Yii::$app->session->setFlash('warning', 'Subscribe Fail');
  			}
  		}
  	}

  	/*
  	* do validation for userpackage avaialable 
  	*/

  	protected static function availableSubscribe()
  	{
  		$data = UserPackage::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
  		if($data)
  		{
  			return true;
  		}
  		else
  		{
  			return false;
  		}
  	}

	/*
	* make subscire saving data
	* data => post data
	* currentDate => current time
	* endTime => which date should ended
	*/

	protected static function makeSubscribe($data,$currentDate,$endTime)
	{
		$subscribe = new Userpackage();
		$subscribe->uid = Yii::$app->user->identity->id;

    $subscribe->type = $data['sub_period'];
		$subscribe->packid = $data['packid'];

		$endDate = date('Y-m-d h:i:s',strtotime($endTime));

		$period = date_diff(date_create($currentDate),date_create($endDate));
		$subscribe->sub_period = $period->days;

    $subscribe->subscribe_time = $currentDate;
    $subscribe->end_period = $endDate;
     
    return $subscribe;
	}

	/*
	* make user package data
	* endTime => which date should ended
	* nextTime => next payment date
	*/
	protected static function makePackageSubscribe($endTime,$nextTime)
	{
		
		$userpackagesubscription = new Userpackagesubscription();

		$userpackagesubscription->uid = Yii::$app->user->identity->id;
		
		$endDate = date('Y-m-d h:i:s',strtotime($endTime));
		$nextDate = date('Y-m-d h:i:s',strtotime($nextTime));

		$userpackagesubscription->end_period = $endDate;

        $userpackagesubscription->next_payment = $nextDate;
       
        return $userpackagesubscription;
	}

	/*
	* make subscire history data
	* subscribe => all the subscire data
	* payment => all the payment data
	*/

	protected static function makeSubscribeHistory($subscribe,$payment)
	{
		$subscribehistory = new SubscribePackageHistory();
		$subscribehistory->uid = $subscribe['uid'];

        $subscribehistory->pay_date = $subscribe['subscribe_time'];
        $subscribehistory->subscribe_date = $subscribe['subscribe_time'];
        $subscribehistory->subscribe_period = $subscribe['sub_period'];
        $subscribehistory->end_date = $subscribe['end_period']; 
        $subscribehistory->pay_type = $payment['paid_type'];
        $subscribehistory->packid = $subscribe['packid'];
		$subscribehistory->pack_type = $subscribe['type'];

		$subscribehistory->payid = $payment['id'];
        $subscribehistory->amount = $payment['paid_amount'];

		$subscribehistory->grade = "";
		return $subscribehistory;
	}

	/*
	* sending email
	*/

	protected static function makeEmail($userpackagesubscription)
	{
		$model = Userpackage::find()->joinWith('package')->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
		$user = Yii::$app->user->identity;
		$userdetails = UserDetails::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        if (empty($userdetails)) {
            $userdetails = new UserDetails();
        }
		$email = \Yii::$app->mailer->compose(['html' => 'SubscriptionReceipt-html'],['model' => $model,'userpackagesubscription'=>$userpackagesubscription,'userdetails' => $userdetails,'user' => $user])//pass value)
        ->setTo($user['email'])
        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
        ->setSubject('Subscription Receipt')
        ->send();
	}
}

