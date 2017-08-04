<?php

namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Vouchers;
use backend\models\Admin;

class VouchersController extends CommonController
{
    public function actionIndex()
    {
        $searchModel = new Vouchers();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
    }

    public function actionAdd()
    {
    	
        $model = new Vouchers;
        $model->inCharge = Admin::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->adminname;
        $model->status = 'Activated';
        $model->startDate = date('Y-m-d');
        $model->endDate = date('Y-m-d',strtotime('+30 day'));

        if( $model->load(Yii::$app->request->post()))
        {
            $isValid = $model->validate();
            //var_dump($isValid);exit;
          	$checkcode = Vouchers::find()->where('code = :c', [':c' => $model->code])->one(); //查询是否重复code

          	if($isValid && (empty($checkcode)))
          	{
                $model->save();
                Yii::$app->session->setFlash('success', "Update completed");
          	}
            elseif(!empty($checkcode))
            {
                Yii::$app->session->setFlash('warning', "Duplicated Voucher Code");//是重复，警告
            }
            else
            {
                Yii::$app->session->setFlash('Warning', " completed");
            }
        }
               
        return $this->render('addvouchers', ['model' => $model]);
    }


}
