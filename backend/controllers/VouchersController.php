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
    		$del = self::actionBatchDelete($selection);
    	}
    	

    	if (Yii::$app->request->post('gen')) {
    		$model = Yii::$app->request->post('Vouchers');
    		$code = self::actionGenCode($model);
    	}

   		return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionBatchDelete($selection)
    {
    	
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


    public function actionGenCode($model)
    {
    	$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
        $admin = Admin::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->adminname;
        $date = date('Y-m-d');
        $month = date('Y-m-d',strtotime('+30 day'));
        for ($j=0; $j <= 10 ; $j++) { 

        	$model = new Vouchers;
        	$model->discount =10;
        	$model->inCharge = $admin;
        	$model->startDate = $date;
      		$model->endDate = $month;
      		$model->status = 0;

           	for($i=0;$i<16; $i++){
       			$model->code .= $chars[rand(0,strlen($chars)-1)];
    		}
    		//var_dump($model->save());exit;
    		$model->save(false);
        }

    	Yii::$app->session->setFlash('success', "10 Code Generated!");
    	
    }

}
