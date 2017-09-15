<?php

namespace frontend\controllers;
use common\models\Package;
use common\models\User\UserPackage;
use common\models\User\UserPackageSubscription;
use common\models\User\User;
use common\models\User\UserBalance;
use common\models\Payment;
use common\models\SubscribePackageHistory;
use common\models\SubscribeType;
use yii\helpers\ArrayHelper;
use Yii;

class SubscribeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $package = Package::find()->all();
        $subscribe = UserPackage::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        $subscribehistory = new SubscribePackageHistory();
        $userbalance = UserBalance::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        $payment = new Payment();
        $user = User::find()->where('id = :id',[':id' => $subscribe->uid])->one();
		$userpackagesubscription = Userpackagesubscription::find()->where('uid = :id',[':id' => Yii::$app->user->identity->id])->one();
        if (empty($userpackagesubscription)){
          $userpackagesubscription = new Userpackagesubscription();
        }
		$items = ArrayHelper::map(SubscribeType::find()->where(['or',['id'=>2],['id'=>4],['id'=>5],['id'=>6]])->all(),'id','description');
	
		
        if (empty($subscribe)){
          $subscribe = new UserPackage();
        }
		
		if (empty($userpackagesubscription)){
          $userpackagesubscription = new Userpackagesubscription();
        }

        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $date = mktime(0,1,0,$month,$day,$year);
        $date = date('Y-m-d h:i:s',$date);
        
        if (Yii::$app->request->post())
        {  
            
			$post = Yii::$app->request->post();
		
            $subscribe->load($post);
            $payment->load($post);
            $subscribe->uid = Yii::$app->user->identity->id;
            $payment->uid = Yii::$app->user->identity->id;
            $payment->paid_type = 1;
            $payment->item = 'Subscription';
            $payment->original_price = $payment->paid_amount;
			
			$id = $subscribe->sub_period;
			switch ($id) {
			case 2:
			$end_period = mktime(0,1,0, $month+1,$day,$year);
			$end_period = date('Y-m-d h:i:s',$end_period);
			$subscribe->sub_period =1;
				break;
			case 4:
			$end_period = mktime(0,1,0, $month+1,$day,$year);
		    $end_period = date('Y-m-d h:i:s',$end_period);
		    $subscribe->sub_period =30;
				break;
			case 5:
			$end_period = mktime(0,1,0, $month,$day,$year+1);
			$end_period = date('Y-m-d h:i:s',$end_period);
			$subscribe->sub_period =360;
			 	break;
			case 6:
			$end_period = mktime(0,1,0, $month,$day,$year+1);
			$end_period = date('Y-m-d h:i:s',$end_period);
			$subscribe->sub_period =365;
			 	break;
			default:
				$end_period="";
				break;
		}
		$subscribe->type = $id;
		//var_dump($subscribe); exit;
			
           /* if ($subscribe->sub_period == 12) {
              $end_period = strtotime('+1 year',strtotime($date));
              $end_period = date('Y-m-d h:i:s',$end_period);
            } else {
              $end_period = strtotime('+1 month',strtotime($date));
              $end_period = date('Y-m-d h:i:s',$end_period);
            } */
            $subscribe->subscribe_time = $date;
            $subscribe->end_period = $end_period;

            if ($userbalance->balance >= $payment->paid_amount) {
                $subscribe->save();
                $userbalance->balance -= $payment->paid_amount;
                $userbalance->save();
                $payment->save();
                $subscribehistory->uid = $subscribe->uid;
                $subscribehistory->payid = $payment->id;
                $subscribehistory->amount = $payment->paid_amount;
                $subscribehistory->pay_date = $date;
                $subscribehistory->type = $payment->paid_type;
                $subscribehistory->packid = $subscribe->packid;
                $subscribehistory->subscribe_period = $subscribe->sub_period;
                $subscribehistory->subscribe_date = $subscribe->subscribe_time;
                $subscribehistory->end_date = $subscribe->end_period;
                $subscribehistory->save();
				
				$userpackagesubscription->uid = $subscribe->uid;
				$userpackagesubscription->end_period = $subscribe->end_period;
				$userpackagesubscription->next_payment = date('Y-m-d h:i:s',strtotime('-330 days',strtotime($subscribe->end_period)));
				$userpackagesubscription->save();
                $model = Userpackage::find()->joinWith('package')->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id])->one();
                $email = \Yii::$app->mailer->compose(['html' => 'SubscriptionReceipt-html'],['model' => $model])//pass value)
                ->setTo($user->email)
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setSubject('Subscription Receipt')
                ->send();
                Yii::$app->session->setFlash('success', 'Subscription Successful.');
				return $this->redirect(['/user/userpackage']);
            } else {
                Yii::$app->session->setFlash('warning', 'Failed to subscribe. Not enough balance to subscribe.');
            }
        }
        return $this->render('index',['package' => $package,'subscribe'=>$subscribe,'items'=>$items, 'payment'=>$payment]);
    }
}
