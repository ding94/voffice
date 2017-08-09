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
                Yii::$app->session->setFlash('error', "Duplicated Voucher Code");//是重复，警告
            }
            else
            {
                Yii::$app->session->setFlash('danger', "Unexpected error, please contact IT department");
            }
        }
               
        return $this->render('addvouchers', ['model' => $model]);
    }


    //批量做法
    public function actionBatch(){
    	//var_dump(Yii::$app->request->post());exit;
    	if (Yii::$app->request->post('remove')) {
    		$selection=Yii::$app->request->post('selection'); //拿取选择的checkbox + 他的 id
    		$del = self::actionBatchDelete($selection); //传走去 actionBatchDelete
    	}
    	
   		return $this->redirect(Yii::$app->request->referrer);
    }


    //批量删除
    public function actionBatchDelete($selection)
    {
    		
    		 if (!empty($selection)) {
    	 			foreach($selection as $id){
       			 	$delete=Vouchers::findOne((int)$id);//make a typecasting //找一个删一个
      		 		$delete->delete();
      		 		Yii::$app->session->setFlash('success', "Deleted!");
    			}
    	 	}
    	 	else
    	 	{
    	 		Yii::$app->session->setFlash('warning', "No Voucher/Record was selected!");
    	 	}
    }

     //批量制造code
    public function actionGencodes()
    {
		$model = new Vouchers;
		$model->startDate = date('Y-m-d');
        $model->endDate = date('Y-m-d',strtotime('+30 day'));
        $model->digit = 16;
    	 if( $model->load(Yii::$app->request->post()))
        {
        	
        	//var_dump($model->amount);exit;
    		$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";//code 包含字母
        	//找Admin 一样可以用下面的这条code
        	//Admin::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->adminname;
    		$amount = $model->amount;
    		$digit = $model->digit;
    		$dis = $model->discount;
    		$startDate = $model->startDate;
    		$endDate = $model->endDate;
        	//第一个for 制造code 的数量，第二个for制造code包含16个字母
        	for ($j=1; $j <= $amount ; $j++) { 

        		$model = new Vouchers;
        		$model->inCharge = Yii::$app->user->identity->adminname;
      			$model->status = 0;
      			$model->discount = $dis;
      			$model->startDate = $startDate;
    			$model->endDate = $endDate;

           		for($i=0;$i<$digit; $i++){
       				$model->code .= $chars[rand(0,strlen($chars)-1)];
    			}
    		
    			if (Vouchers::find()->where('code = :c', [':c' => $model->code])->one()==true) {
    				$j=0;
    				return false;
    			}
    			else{
    				$model->save(false);
    			}
    		
        	}
        	
        	Yii::$app->session->setFlash('success', $amount." Code Generated!");
    	}

    	return $this->render('gencodes', ['model' => $model]);
    	
    }

}
