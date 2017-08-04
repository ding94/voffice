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
        
 		//var_dump($string);exit;
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

    public function actionDelete()
     {
     	$model = Vouchers::find()->all();
     	return $this->render('deletevouchers', ['model' => $model]);
     }

    public function actionBatch(){

    	if (Yii::$app->request->post('remove')) {
    		$selection=Yii::$app->request->post('selection'); //拿取选择的checkbox + 他的 id
    		var_dump(Yii::$app->request->post('gen'));exit;
    		 if (!empty($selection)) {
    	 			foreach($selection as $id){
       			 	$delete=Vouchers::findOne((int)$id);//make a typecasting
      		 		$delete->delete();
      		 		Yii::$app->session->setFlash('success', "Deleted!");
    			}
    	 	}
    	 	else
    	 	{
    	 		Yii::$app->session->setFlash('warning', "No Voucher/Record was selected!");
    	 	}
    	}
    	

   		return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionGenCode()
    {
    	if (Yii::$app->request->post('gen')) {
    		var_dump("hi");exit;
    	}
    	
    	$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
        $string='';
         for($i=0;$i<16; $i++){
       		 $string .= $chars[rand(0,strlen($chars)-1)];
 
    	}



    	Yii::$app->session->setFlash('success', "10 Code Generated!");
    	return $this->redirect(Yii::$app->request->referrer);
    }


}
