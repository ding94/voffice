<?php

namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use backend\models\Vouchers;
use common\models\User\UserVoucher;
use backend\models\VouchersStatus;
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
        $model->scenario = 'add';
        $model->inCharge = Admin::find()->where('id = :id',[':id' => Yii::$app->user->identity->id])->one()->adminname;
        $model->startDate = date('Y-m-d');
        //$model->endDate = date('Y-m-d',strtotime('+30 day'));
        $list = ArrayHelper::map(VouchersStatus::find()->where(['or',['id'=>1],['id'=>4]])->all(),'id','type');
        
        if( $model->load(Yii::$app->request->post()))
        {
            $valid = self::discountvalid(Yii::$app->request->post());
            if ($valid) 
            {
                return $this->redirect(['add']);
            }
            $model->status = Yii::$app->request->post('Vouchers')['status'];
            $model->type = $list[$model->status];
            $isValid = $model->validate();
          	$checkcode = Vouchers::find()->where('code = :c', [':c' => $model->code])->one(); //查询是否重复code

          	if($isValid && (empty($checkcode)))
          	{
                $model->save();
                Yii::$app->session->setFlash('success', "Created!");
                return $this->redirect(['add']);
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
               
        return $this->render('addvouchers', ['model' => $model,'list'=>$list]);
    }


    //批量做法
    public function actionBatch(){
        
    	if (Yii::$app->request->post('selection')) {
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
                        if (UserVoucher::find()->where('vid = :id', [':id' => $id])->one()) {
                            $del = UserVoucher::find()->where('vid = :id', [':id' => $id])->one();
                            $del->delete();
                        }
                        
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
        $model->scenario = 'generate'; // set senario, 为了model 的 rule 来判断
		$model->startDate = date('Y-m-d');
        //$model->endDate = date('Y-m-d',strtotime('+30 day'));
        $model->digit = 16;
        $list = ArrayHelper::map(VouchersStatus::find()->where(['or',['id'=>1],['id'=>4]])->all(),'id','type');
    	if( $model->load(Yii::$app->request->post()))
        {
        	
        	$valid = self::discountvalid(Yii::$app->request->post());
            if ($valid) 
            {
                return $this->redirect(['gencodes']);
            }
    		$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";//code 包含字母
    		$amount = $model->amount;
    		$digit = $model->digit;
    		$dis = $model->discount;
    		$startDate = $model->startDate;
    		$endDate = $model->endDate;
    		$count = 0;
        	//第一个for 制造code 的数量，第二个for制造code包含16个字母
        	for ($j=1; $j <= $amount ; $j++) { 

        		$model = new Vouchers;
        		$model->inCharge = Yii::$app->user->identity->adminname;
      			$model->status = Yii::$app->request->post('Vouchers')['status'];
                $model->type = $list[$model->status];
      			$model->discount = $dis;
      			$model->startDate = $startDate;
    			$model->endDate = $endDate;

           		for($i=0;$i<$digit; $i++){
       				$model->code .= $chars[rand(0,strlen($chars)-1)];
    			}
    			if (Vouchers::find()->where('code = :c', [':c' => $model->code])->one()==true) {
    				$j=1;
    				$count +=1;
    				if ($count >10) {
    					Yii::$app->session->setFlash('error','All generated code duplicated!');
    					return $this->redirect(Yii::$app->request->referrer);
    				}
    			}
    			else{
    				$model->save(false);
    				$model->discount='';
    				$model->code =16;
    				
    			}
    		
        	}
        	
        	Yii::$app->session->setFlash('success', $amount." Code Generated!");
    	}

    	return $this->render('gencodes', ['model' => $model,'list'=>$list]);
    	
    }

    public static function discountvalid($post)
    {
        if ($post['Vouchers']['status'] == 1) {
                if ($post['Vouchers']['discount']<=0 || $post['Vouchers']['discount'] >= 100) {
                    Yii::$app->session->setFlash('error', "Failed, discount exceed limit!");
                    return true;
                }
            }
        elseif ($post['Vouchers']['status'] == 4) {
                if ($post['Vouchers']['discount']<=0) {
                    Yii::$app->session->setFlash('error', "Failed, discount cannot less than 1!");
                    return true;

                }
            }
     }
    

}
