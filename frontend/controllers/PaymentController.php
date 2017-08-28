<?php

namespace frontend\controllers;
use common\models\Package;
use common\models\Payment;
use common\models\User\User;
use common\models\User\UserBalance;
use Yii;

class PaymentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $package = Package::find()->all();
        $payment = new Payment();
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

    // public function getAmountList($data)
    // {
    //     $amount = ArrayHelper::map(Package::find()->where('id = :id',[':id' => $data])->all(),'id','price');
    //     return $amount;
    // }

  //   public function actionIndex()
  //   {
  //   	$model = new OfflineTopup;
  //   	$upload = new Upload;
  //   	$path = Yii::$app->params['imageLocation'];
  //   	if(Yii::$app->request->post())
  //   	{
  //   		$post = Yii::$app->request->post();
  //   		$model->username = User::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->username;
		// 	$model->action = 1;
		// 	$model->action_before=1;
  //   		$upload->imageFile =  UploadedFile::getInstance($upload, 'imageFile');
  //   		$upload->imageFile->name = time().'.'.$upload->imageFile->extension;

  //   		$post['OfflineTopup']['picture'] = $path.'/'.$upload->imageFile->name;
  //   		$upload->upload();
  //   		$model->load($post);
  //   		$model->save(false);
		// 	Yii::$app->session->setFlash('success', 'Upload Successful');
  //   	}
		// $model->amount ="";
		// $model->description ="";
		// $this->layout = 'user';
  //   	return $this->render('index' ,['model' => $model , 'upload' => $upload]);
		// //Yii::app()->end();
  //   }
	
}
