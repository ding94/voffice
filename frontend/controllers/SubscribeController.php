<?php

namespace frontend\controllers;
use common\models\Package;
use common\models\User\UserPackage;
use common\models\User\UserPackageSubscription;
use common\models\User\User;
use common\models\User\UserDetails;
use common\models\User\Uservoucher;
use backend\models\Vouchers;
use common\models\Payment;
use common\models\PaymentType;
use common\models\SubscribePackageHistory;
use common\models\SubscribeType;
use frontend\controllers\PaymentController;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use Yii;

class SubscribeController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$subscribe = new UserPackage();

    	$items = ArrayHelper::map(SubscribeType::find()->where(['or',['id'=>2],['id'=>4],['id'=>5],['id'=>6]])->all(),'id','description');
      //var_dump(Payment::find()->one());exit;
    	$payment = new Payment();

    	return $this->render('index',['subscribe'=>$subscribe,'items'=>$items, 'payment'=>$payment]);
    }

     public function actionGetdiscount($dis)
    {
       $valid = UserVoucher::find()->where('code = :c',[':c'=>$dis])->one();
       if (!empty($valid)) {
          if ($valid->limitedTime > date('Y-m-d')) {
            $value = Vouchers::find()->where('code = :c',[':c'=>$dis])->one();
          }
          elseif ($valid->limitedTime < date('Y-m-d')) {
           $value = 0;
          }
       }
       elseif(empty($valid)) {
       
        $value = 0;
       }
       $value = Json::encode($value);

       return $value;

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
        return $this->redirect(['user/userpackage']);
  		}
  		elseif($available == false)
  		{
        $post = Yii::$app->request->post();
         return $this->redirect(['subscribe/payment','pack' => $post['UserPackage']['packid'],'period' => $post['UserPackage']['sub_period']]);
  			//self::processAll();
  		}
      else
      {
        return $this->redirect(['user/userpackage']);
      }
  		
  	}

    public function actionPayment($pack,$period)
    {
      
      $package = Package::find()->where('id = :id',[':id' => $pack])->one();
      $subscribe = SubscribeType::find()->where('id =:id',[':id'=>$period])->one();
      $payment = new Payment;
      $this->layout = 'user';

      if (Yii::$app->request->post()) {
        if (!empty(Yii::$app->request->post('Payment')['paid_type'])) {
          $payment = self::processAll();
          return $this->redirect(['subscribe/invoice','payid'=>$payment['id']]);
        }
        else if (empty(Yii::$app->request->post('Payment')['paid_type'])) {
          Yii::$app->session->setFlash('warning', 'Please Choose Your Payment Method.');
          
        }
        
      }
      //var_dump($package);var_dump($subscribe);exit;
      return $this->render('payment',['package'=>$package,'subscribe'=>$subscribe,'payment'=>$payment]);
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

  		$subscribeType = SubscribeType::findOne($post['SubscribeType']['id']);
      $package = Package::findOne($post['Package']['id']);

  		$payment = PaymentController::makeSubscribePayment($package['price'],$subscribeType['times']);
      
      if (!empty($post['Payment']['voucher_id'])) {
        $voucher = Vouchers::find()->where('code =:c AND status =:s',[':c'=>Yii::$app->request->post('Payment')['coupon'],':s'=>2])->one();
        if (!empty($voucher)) {
          switch ($voucher->discount_item) 
          {
            case 1:
              if ($voucher->discount_type == 1) 
             {
                $payment->paid_amount = $payment->paid_amount *((100 - $voucher->discount) /100); 
              
             }
             else if ($voucher->discount_type == 2) 
             {

                $payment->paid_amount = $payment->paid_amount - $voucher->discount;  
             }
              break;

          case 2:
               if ($voucher->discount_type == 1) 
             {
                $payment->paid_amount = ($package->price * (100 - $voucher->discount)/100)* $subscribeType->times;
              
             }
             else if ($voucher->discount_type == 2) 
             {
                $payment->paid_amount = ($package->price - $voucher->discount)* $subscribeType->times;
             }
              break;
          default:

              break;
          }

          $payment->voucher_id = $voucher->id;
          $payment->discount = $payment->original_price - $payment->paid_amount;
          $voucher->status = 3;
          $voucher->usedTimes += 1;
          if ($voucher->validate()) {
            $voucher->save();
          }
        }
        
      }

  		$subscribe = self::makeSubscribe($package['id'],$subscribeType['id'],$currentDate,$subscribeType['sub_period']);

  		$userbalance = PaymentController::getPaymentBalance($payment['paid_amount'],$subscribeType['times']);
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
          return $payment;
  			}
  			else
  			{
  				Payment::deleteAll('id = :id' ,[':id' => $payment['id']] );
  				Subscribe::deleteAll('uid = :uid' ,[':uid' => Yii::$app->user->identity->id]);
  				Yii::$app->session->setFlash('warning', 'Subscribe Fail');
  			}
  		}
  	}

    public function actionInvoice($payid)
    {
      $payment = Payment::find()->where('id = :id',[':id'=>$payid])->one();
      $package = UserPackage::find()->where('uid = :id',[':id'=>$payment['uid']])->one();
      $package['packid'] = Package::find()->where('id = :id',[':id'=>$package['packid']])->one()->type;
      $next = UserPackageSubscription::find()->where('uid = :id',[':id'=>$payment['uid']])->one();
      $voucher = Vouchers::find()->where('id = :id',[':id'=>$payment['voucher_id']])->one();
      $payment['paid_type'] = PaymentType::find()->where('id = :id',[':id'=>$payment['paid_type']])->one()->description;

      return $this->render('invoice',['payment'=>$payment,'package'=>$package,'next'=>$next,'voucher'=>$voucher]);

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

	protected static function makeSubscribe($packid,$period,$currentDate,$endTime)
	{
		$subscribe = new Userpackage();
		$subscribe->uid = Yii::$app->user->identity->id;

    $subscribe->type = $period;
		$subscribe->packid = $packid;

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

