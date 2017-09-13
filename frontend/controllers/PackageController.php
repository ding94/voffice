<?php

namespace frontend\controllers;
use common\models\Package;
use common\models\User\UserPackage;
use common\models\User\User;
use common\models\User\UserBalance;
use common\models\Payment;
use common\models\SubscribePackageHistory;
use common\models\SubscribeType;
use yii\helpers\ArrayHelper;
use frontend\controllers\SubscribeController;
use Yii;

class PackageController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$package = Package::find()->all();
        $subscribe = UserPackage::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        $subscribehistory = new SubscribePackageHistory();
        $userbalance = UserBalance::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        $payment = new Payment();
	
		$items = ArrayHelper::map(SubscribeType::find()->where(['or',['id'=>2],['id'=>4],['id'=>5],['id'=>6]])->all(),'id','description');
		//$items = ArrayHelper::map(SubscribeType::find()->where(['options'=> [$_GET['id']=>['Selected'=>'selected']]]));
		
	
		
        if (empty($subscribe)){
          $subscribe = new UserPackage();
        }

        $date = Yii::$app->formatter->asDatetime(date('Y-m-d h:i:s'));
        
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
			$end_period = strtotime('+1 month',strtotime($date));
			$end_period = date('Y-m-d h:i:s',$end_period);
			$subscribe->sub_period =1;
				break;
			case 4:
			$end_period = strtotime('+1 month',strtotime($date));
		    $end_period = date('Y-m-d h:i:s',$end_period);
		    $subscribe->sub_period =30;
				break;
			case 5:
			$end_period = strtotime('+1 years',strtotime($date));
			 $end_period = date('Y-m-d h:i:s',$end_period);
			 $subscribe->sub_period =360;
			 	break;
			case 6:
			$end_period = strtotime('+1 year',strtotime($date));
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
                Yii::$app->session->setFlash('success', 'Subscription Successful');
				return $this->redirect(['/user/userpackage']);
            } else {
                Yii::$app->session->setFlash('warning', 'Subscription failed');
            }
        }
        return $this->render('index',['package' => $package,'subscribe'=>$subscribe,'items'=>$items, 'payment'=>$payment]);
    }
}
    