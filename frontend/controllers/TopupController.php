<?php

namespace frontend\controllers;
use common\models\OfflineTopup;
use common\models\User\User;
use common\models\Upload;
use Yii;
use yii\web\UploadedFile;

class TopupController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$model = new OfflineTopup;
    	$upload = new Upload;
    	$path = Yii::$app->params['imageLocation'];
    	if(Yii::$app->request->post())
    	{
    		$post = Yii::$app->request->post();
    		$model->username = User::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->username;
    		$upload->imageFile =  UploadedFile::getInstance($upload, 'imageFile');
    		$upload->imageFile->name = time().'.'.$upload->imageFile->extension;

    		$post['OfflineTopup']['picture'] = $path.'/'.$upload->imageFile->name;
    		$upload->upload();
    		$model->load($post);
    		$model->save(false);
    	}
    	return $this->render('index' ,['model' => $model , 'upload' => $upload]);
    }
	
}
