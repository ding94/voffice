<?php

namespace frontend\controllers;
use common\models\Package;
use common\models\User\UserPackage;
use common\models\User\User;
use common\models\User\UserBalance;
use common\models\Payment;
use Yii;

class SubscribeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $package = Package::find()->all();
        $subscribe = UserPackage::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        $userbalance = UserBalance::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        $payment = new Payment();

        if (empty($subscribe)){
          $subscribe = new UserPackage();
        }

        $date = Yii::$app->formatter->asDatetime(date('Y-m-d h:i:s'));
        
        $end_period = strtotime('+1 year',strtotime($date));
        $end_period = date('Y-m-d h:i:s',$end_period);
        
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
            $subscribe->subscribe_time = $date;
            $subscribe->end_period = $end_period;
            $subscribe->sub_period = 12;

            if ($userbalance->balance >= $payment->paid_amount) {
                $subscribe->save();
                $userbalance->balance -= $payment->paid_amount;
                $userbalance->save();
                $payment->save();
                Yii::$app->session->setFlash('success', 'Subscription Successful');
            } else {
                Yii::$app->session->setFlash('warning', 'Subscription failed');
            }
        }
        return $this->render('index',['package' => $package,'subscribe'=>$subscribe, 'payment'=>$payment]);
    }
}
