<?php

namespace frontend\controllers;
use common\models\Package;
use common\models\User\UserPackage;
use common\models\User\User;
use common\models\User\UserBalance;
use Yii;

class SubscribeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $package = Package::find()->all();
        $subscribe = UserPackage::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        $userbalance = UserBalance::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();

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
            $subscribe->uid = Yii::$app->user->identity->id;
            $subscribe->subscribe_time = $date;
            $subscribe->end_period = $end_period;
            $subscribe->sub_period = 12;
            $subscribe->save();
            if ($subscribe->save()) {
                // $subscribe->save();
                // $userbalance->balance -= $subscribe->amount;
                // $userbalance->save();
                Yii::$app->session->setFlash('success', 'Subscription Successful');
            } else {
                Yii::$app->session->setFlash('warning', 'Subscription failed');
            }
        }
        return $this->render('index',['package' => $package,'subscribe'=>$subscribe]);
    }

    public function actionConfirmpayment()
    {
      $package = Package::find()->all();
      $payment = new UserPackage();
      $userbalance = UserBalance::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
      if (Yii::$app->request->post())
        {  
            $post = Yii::$app->request->post();
            $payment->load($post);
            $payment->uid = Yii::$app->user->identity->id;
            $payment->type =  1;
            if ($userbalance->balance >= $payment->amount ) {
                $payment->save();
                $userbalance->balance -= $payment->amount;
                $userbalance->save();
                Yii::$app->session->setFlash('success', 'Payment Successful');
            } else {
                Yii::$app->session->setFlash('warning', 'Payment failed');
            }
        }
    }
}
