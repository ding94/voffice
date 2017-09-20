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

    	if(Yii::$app->request->isPost)
    	{
    		$post = Yii::$app->request->post();

    		$paymentData = self::getPayment($post);
    		if($paymentData)
    		{
    			$isValid = self::makeSubscribeHistory($paymentData['subscribe'],$paymentData['payment']);
    			if($isValid->save())
    			{
    				Yii::$app->session->setFlash('warning', 'Subscribe Success');
    			}
    			else
    			{
    				var_dump($isValid->errors);exit;
    			}
    		}
    		
    	}
    	return $this->render('index',['subscribe'=>$subscribe,'items'=>$items, 'payment'=>$payment]);
    }

    protected static function getPayment($post)
    {
    	$data = "";
    	$makePayment = self::makePayment($post['Payment']);

    	$userBalance = PaymentController::getPaymentBalance($makePayment['original_price']);

    	$makeSubscribe = self::makeSubscribe($post['UserPackage']);

    	$makePackageSubscribe = self::makePackageSubscribe($post['UserPackage']);
    		
    	$isValid = $makePayment->validate() && $userBalance->validate() && $makeSubscribe->validate() && $makePackageSubscribe->validate();
    	
    	if($isValid)
    	{
    		$makePayment->save();
    		$userBalance->save();
    		$makeSubscribe->save();
    		$makePackageSubscribe->save();
    		$data['payment'] = $makePayment;
    		$data['subscribe'] = $makeSubscribe;
    		return $data;
    	}
    	else
    	{
    		Yii::$app->session->setFlash('warning', 'Subscribe failed');
    		return $data;
    	}
    }

	protected static function makePayment($data)
	{
		$payment = new Payment();
		$payment->uid = Yii::$app->user->identity->id;
        $payment->paid_type = 1;
        $payment->item = 'Subscription';
        $payment->original_price = $data['paid_amount'];
        $payment->paid_amount = $data['paid_amount'] ;
        
        return $payment;
	}

	protected static function makeSubscribe($data)
	{
		$subscribe = new Userpackage();
		$subscribe->uid = Yii::$app->user->identity->id;

        $subscribe->type = $data['sub_period'];
		$subscribe->packid = $data['packid'];
		$time = self::makePeriodDuration($data['sub_period']);
		
		$subscribe->sub_period = $time['sub_period'];

        $subscribe->subscribe_time = $time['date'];
        $subscribe->end_period = $time['end_period'];
     
        return $subscribe;
	}

	protected static function makePackageSubscribe($data)
	{
		$userpackagesubscription = new Userpackagesubscription();

		$userpackagesubscription->uid = Yii::$app->user->identity->id;

		$time = self::makePeriodDuration($data['sub_period']);
		
		$userpackagesubscription->end_period = $time['end_period'];
        $userpackagesubscription->next_payment = date('Y-m-d h:i:s',strtotime('-330 days',strtotime( $time['end_period'])));

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

	/*protected static function rank($packid)
	{
		$rank = Package::find()->where('id = :id',[':id' => $packid])->one()->rank;
		$grade = "";

		if($package < $rank){
			$grade = 8; //value retrieve from subscribe_type

		}
				
		elseif($package > $rank){
			$grade =  9;
		}
		return $grade;		
	}*/

	protected static function makePeriodDuration($subPeriod)
	{
		$year = date('Y');
        $month = date('m');
        $day = date('d');
        $date = mktime(0,1,0,$month,$day,$year);
        $date = date('Y-m-d h:i:s',$date);
        $data = "";
        $sub = "";

        switch ($subPeriod) {
			case 2:
			$end_period = mktime(0,1,0, $month+1,$day,$year);
		
			$sub =1;
				break;
			case 4:
			$end_period = mktime(0,1,0, $month+1,$day,$year);
		    
		    $sub =30;
				break;
			case 5:
			$end_period = mktime(0,1,0, $month,$day,$year+1);
			
			$sub =360;
			 	break;
			case 6:
			$end_period = mktime(0,1,0, $month,$day,$year+1);

			$sub =365;
			 	break;
			default:
				$end_period= 0;
				break;
        }

        $end_period = date('Y-m-d h:i:s',$end_period);

        $data['date'] = $date;
        $data['sub_period'] = $sub;
        $data ['end_period'] = $end_period;

        return $data;
	}
}

