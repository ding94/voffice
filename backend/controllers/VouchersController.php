<?php

namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use backend\models\Vouchers;
use common\models\User\UserVoucher;
use backend\models\VouchersStatus;
use common\models\VouchersDiscount;
use common\models\VouchersDiscountItem;
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
        $model->inCharge = Yii::$app->user->identity->adminname;
        $model->startDate = date('Y-m-d');
        //$model->endDate = date('Y-m-d',strtotime('+30 day'));
        $list = ArrayHelper::map(VouchersDiscount::find()->all(),'id','description');
        $item = ArrayHelper::map(VouchersDiscountItem::find()->all(),'id','description');
        
        if( Yii::$app->request->post())
        {
            $model->load(Yii::$app->request->post());
            $valid = self::discountvalid(Yii::$app->request->post(),1);
            if ($valid == false){
                return $this->render('addvouchers', ['model' => $model,'list'=>$list]);
            }

            $model->status = 1;
          	if($model->validate()){
                $model->save();
                Yii::$app->session->setFlash('success', "Created!");
                return $this->redirect(['/vouchers/add']);
          	}
            else{
                Yii::$app->session->setFlash('danger', "Unexpected error, please contact IT department");
            }
        }
               
        return $this->render('addvouchers', ['model' => $model,'list'=>$list,'item'=>$item]);
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
        $list = ArrayHelper::map(VouchersDiscount::find()->all(),'id','description');
        $item = ArrayHelper::map(VouchersDiscountItem::find()->all(),'id','description');
    	if( $model->load(Yii::$app->request->post()))
        {
        	$valid = self::discountvalid(Yii::$app->request->post(),2);
            
            if ($valid == false) 
            {
                return $this->render('gencodes', ['model' => $model,'list'=>$list,'item'=>$item]);
            }
           
    		$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";//code 包含字母
    		$amount = $model->amount;
    		$digit = $model->digit;
    		$dis = $model->discount;
            $typ = $model->discount_type;
            $ite = $model->discount_item;
    		$startDate = $model->startDate;
    		$endDate = $model->endDate;
    		$count = 0;
        	//第一个for 制造code 的数量，第二个for制造code包含16个字母
        	for ($j=1; $j <= $amount ; $j++) { 

        		$model = new Vouchers;
        		$model->inCharge = Yii::$app->user->identity->id;
      			$model->status = 1;
                $model->discount = $dis;
                $model->discount_type = $typ;
                $model->discount_item = $ite;
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
    				$model->save();
    			}
    		
        	}
        	Yii::$app->session->setFlash('success', $amount." Code Generated!");
        	return $this->redirect(['vouchers/gencodes']);
    	}

    	return $this->render('gencodes', ['model' => $model,'list'=>$list,'item'=>$item]);
    	
    }

    public static function discountvalid($post,$case)
    {
        switch ($case) {
            case 1:
                $check = Vouchers::find()->where('code = :c',[':c'=>$post['Vouchers']['code']])->one();//查询是否重复code
                if (empty($check)) {
                    $valid = self::discountExceed($post['Vouchers']['discount_type'],$post['Vouchers']['discount']);
                    if ($valid == true) {
                        return true;
                    }
                    return false;
                }
                elseif(!empty($check))
                {
                    Yii::$app->session->setFlash('error', "Voucher Code was used!");
                    return false;
                }
                return true;
                break;
                
            case 2:
                $valid = self::discountExceed($post['Vouchers']['discount_type'],$post['Vouchers']['discount']);
                    if ($valid == true) {
                        return true;
                    }
                    return false;
                break;
            default:
                Yii::$app->session->setFlash('error', "Something went wrong!");
                return false;
                break;
        }
    }

    public static function discountExceed($type,$discount)
    {
        if ($type == 1 && $discount >= 101){
            Yii::$app->session->setFlash('error', "Failed, discount cannot exceed 100%!");
            return false;
        }
        elseif ($type == 2 && $discount >= 500){
            Yii::$app->session->setFlash('error', "Failed, discount cannot exceed RM500!");
            return false;
        }
        return true;
    }
}
