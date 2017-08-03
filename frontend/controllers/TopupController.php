<?php

namespace frontend\controllers;
use common\models\OfflineTopup;
use common\models\User\User;
use Yii;
use yii\web\UploadedFile;

class TopupController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$topup = OfflineTopup::find()->all();

       // return $this->render('topup');
    	   
	 //  $this->layout = "topup";
      $model = new OfflineTopup;
      
        $model->amount = '';
        $model->description = '';
       
        return $this->render("index",[
		'model' => $model
		]);
		
		
    }
	    public function actionUpload()
    {
    $model = new OfflineTopup;
	$path = Yii::$app->params['imageLocation'];
//var_dump (Yii::$app->request->post()); exit;
        if (Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$model->username = User::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->username;
            $model->picture = UploadedFile::getInstance($model, 'picture');
			$model->picture->name = time().'.'.$model->picture->extension;
			$post['OfflineTopup']['picture'] = $path.'/'.$model->picture->name;
           
		   if ($model->upload()) {
			   $model->picture = $path.'/'.$model->picture->name;
			   $model ->save(false);
				var_dump ( $model->save()); exit;
                // file is uploaded successfully
               // return;

            }
        }
        return $this->render('index', ['model' => $model]);
    }

	
}
