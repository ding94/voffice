<?php

namespace frontend\controllers;
use common\models\OfflineTopup\OfflineTopup;
use common\models\User\User;
use common\models\Upload;
use common\models\BankDetails;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;


class TopupController extends \yii\web\Controller
{
    public function actionIndex()
    {	
    	$model = new OfflineTopup;
    	$upload = new Upload;
    	$path = Yii::$app->params['imageLocation'];
		//$name = ArrayHelper::map(BankDetails::find()->all(), 'bank_name', 'bank_name');
		$name = ArrayHelper::map(BankDetails::find()->all(), 'id', 'bank_name');
    	if(Yii::$app->request->post())
    	{
    		$post = Yii::$app->request->post();
    		//$model->uid = User::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->uid;
			$model->uid = Yii::$app->user->identity->id;
			//var_dump($model->uid);exit;
			$model->action = 1;
			$model->action_before=1;
    		$upload->imageFile =  UploadedFile::getInstance($upload, 'imageFile');
    		$upload->imageFile->name = time().'.'.$upload->imageFile->extension;
			
    		$post['OfflineTopup']['picture'] = $path.'/'.$upload->imageFile->name;
			if($upload->validate()) //validation
			{
				$upload->upload();
			
				$model->load($post);
					//var_dump($model);exit;
				$model->save(false);
				Yii::$app->session->setFlash('success', 'Upload Successful');
			}
    	
    	}
		$model->amount ="";
		$model->description ="";
		$this->layout = 'user';
		    	return $this->render('index' ,['model' => $model ,'name'=>$name, 'upload' => $upload]);
		//Yii::app()->end();
    }
	
}
