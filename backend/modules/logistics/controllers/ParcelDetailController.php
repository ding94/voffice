<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use common\models\Parcel\ParcelDetail;
use backend\controllers\CommonController;

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
		if($model->load(Yii::$app->request->post()) && $model->save())
		{
			Yii::$app->session->setFlash('success', "Update completed");
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