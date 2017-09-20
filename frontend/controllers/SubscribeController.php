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

    public function actionMakeSubscribe()
  	{
  		$currentDate = date('Y-m-d h:i:s');

  		$post= Yii::$app->request->post();
  		
  		$subscribeType = SubscribeType::findOne($post['UserPackage']['sub_period']);

  		$payment = self::makePayment($post['Payment']['paid_amount'],$subscribeType['times']);

  		$subscribe = self::makeSubscribe($post['UserPackage'],$currentDate,$subscribeType['sub_period']);

  		$userbalance = PaymentController::getPaymentBalance($post['Payment']['paid_amount'],$subscribeType['times']);

  		$packageSubscribe = self::makePackageSubscribe($subscribeType['sub_period'],$subscribeType['next_payment']);
  		
  		$isValid = $payment->validate() && $subscribe->validate() && $packageSubscribe->validate() && $userbalance->validate();
  		
  		if($isValid)
  		{
  			$payment->save();
  			$subscribe->save();
  			$packageSubscribe->save();
  			$subscribeHistory = self::makeSubscribeHistory($subscribe,$payment);
  			if($subscribeHistory->save())
  			{
  				Yii::$app->session->setFlash('success', 'Subscribe Success');
  			}
  			else
  			{
  				Yii::$app->session->setFlash('warning', 'Subscribe Fail');
  			}
  		}
  		return $this->redirect(['user/userpackage']);
  	}

	protected static function makePayment($amount,$times)
	{
		$payment = new Payment();
		$payment->uid = Yii::$app->user->identity->id;
        $payment->paid_type = 1;
        $payment->item = 'Subscription';
        $payment->original_price = $amount * $times;
        $payment->paid_amount = $amount * $times;
        return $payment;
	}

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
}

