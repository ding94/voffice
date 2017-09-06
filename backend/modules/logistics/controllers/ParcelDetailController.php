<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use common\models\Parcel\ParcelDetail;
use backend\controllers\CommonController;
use backend\modules\logistics\controllers\ParcelOperateController;

Class ParcelDetailController extends CommonController
{
	public function actionView($parid,$status)
	{
		$model = $this->findModel($parid);
		return $this->render('view',['model' => $model,'status' => $status]);
	}

	public function actionUpdate($id,$status)
	{
		$model = $this->findModel($id);
		if(Yii::$app->request->isPost)
		{
			$model->load(Yii::$app->request->post());
    		$operate = ParcelOperateController::createOperate($id,$status,2);

    		$isValid = $model->validate() && $operate->validate();
    		
    		if($isValid)
    		{
    			$model->save();
    			$operate->save();
    			
    		}
    		else
    		{
    			Yii::$app->session->setFlash('warning', "Update Fail");
    		}		
			
			return $this->redirect(['view','parid' => $id,'status' => $status]);
		}
		
		return $this->render('update',['model'=> $model,'status' => $status]);
	}

	public static function createDetail($parid,$post)
	{
		$detail = new ParcelDetail;
		$detail->load($post);
		$detail->parid = $parid;
		return $detail;
	}

	protected function findModel($id)
    {
        if (($model = ParcelDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}