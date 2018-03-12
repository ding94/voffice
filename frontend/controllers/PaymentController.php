<?php

namespace frontend\controllers;
use common\models\Package;
use common\models\SubscribePackage;
use common\models\User\User;
use common\models\User\UserBalance;
use common\models\Payment;
use Yii;

class PaymentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $package = Package::find()->all();
        $payment = new SubscribePackage();
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
        return $this->render('index',['package' => $package,'payment'=>$payment]);
    }

    public function actionConfirmpayment()
    {
      $package = Package::find()->all();
      $payment = new SubscribePackage();
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

    // public function actionAmount() {
    //     $out = [];
    //     if (isset($_POST['depdrop_parents'])) {
    //         $parents = $_POST['depdrop_parents'];
    //         if ($parents != null) {
    //             $package_type = $parents[0];
    //             $out = Package::getAmountList($package_type); 
    //             // the getSubCatList function will query the database based on the
    //             // cat_id and return an array like below:
    //             // [
    //             //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
    //             //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
    //             // ]
    //             return json_encode(['output'=>$out, 'selected'=>'']);
    //         }
    //     }
    //     return json_encode(['output'=>'', 'selected'=>'']);
    // }

    public function actionAmount($id) 
    {
        $package = Package::find()->where(['id' => $id])->one();
        echo $package->price;
    }

    public static function getPaymentBalance($total,$times)
    {
        $userbalance = UserBalance::find()->where('uid = :uid',[':uid' => Yii::$app->user->identity->id])->one();
        
        $userbalance->balance -= $total;
        $userbalance->negative += $total;
        return $userbalance;
    }

    /*
    * make payment saving data
    * amount => package price
    * times => base on how many month
    */
    public static function makeSubscribePayment($amount,$times)
    {
        $payment = new Payment();
        $payment->uid = Yii::$app->user->identity->id;
        $payment->paid_type = 1;
        $payment->item = 'Subscription';
        $payment->original_price = $amount * $times;
        $payment->paid_amount = $amount * $times;
        return $payment;
    }	
}
