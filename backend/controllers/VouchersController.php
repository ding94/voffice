<?php

namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\models\User\UserVoucher;
use common\models\vouchers\{Vouchers,VouchersStatus,VouchersDiscount,VouchersDiscountType,VouchersDiscountItem,VouchersConditions,VouchersSetCondition};
use backend\models\Admin;


class VouchersController extends CommonController
{
    public function actionIndex()
    {
        $searchModel = new VouchersDiscount();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,1);
        $title = 'Voucher List';
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel,'title'=>$title]);
    }

    public function actionAdd()
    {

        $model = new Vouchers;
        $discount = new VouchersDiscount;
        //$model->scenario = 'add';
        $model->inCharge = Yii::$app->user->identity->id;
        $model->startDate = date('Y-m-d');
        //$model->endDate = date('Y-m-d',strtotime('+30 day'));
        $list = ArrayHelper::map(VouchersDiscountType::find()->all(),'id','description');
        $item = ArrayHelper::map(VouchersDiscountItem::find()->all(),'id','description');
        $title = 'New voucher';
        if( Yii::$app->request->post())
        {
            $model->load(Yii::$app->request->post());
            $discount->load(Yii::$app->request->post());
            $valid = self::discountvalid(Yii::$app->request->post(),1);
            if ($valid == false){
                return $this->render('addvouchers', ['model' => $model,'discount'=>$discount,'list'=>$list,'item'=>$item,'title'=>$title]);
            }

            $model->status = 1;
          	if($model->validate()){
                $model->save();
                $discount['vid'] = $model['id'];
                if ($discount->validate()) {
                    $discount->save();
                    Yii::$app->session->setFlash('success', "Created!");
                }
                else{
                    $model->delete();
                    Yii::$app->session->setFlash('error', "Voucher Create Failed. Discount can't saved.");
                }
                
                return $this->redirect(['/vouchers/add']);
          	}
            else{
                Yii::$app->session->setFlash('danger', "Unexpected error, please contact IT department");
            }
        }
               
        return $this->render('addvouchers', ['model' => $model,'discount'=>$discount,'list'=>$list,'item'=>$item,'title'=>$title]);
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

                $discount = VouchersDiscount::find()->where('id=:id',[':id'=>$id])->all();
                $number = count($discount);
                foreach ($discount as $k => $vou) {
                    $vou->delete();
                }

                if ($user = UserVoucher::find()->where('vid = :id', [':id' => $vou['vid']])->one()) {
                    $user->delete();
                }
                //var_dump($number);exit;
                if (empty(VouchersDiscount::find()->where('vid=:id',[':id'=>$vou['vid']])->one())) {
                    $voucher=Vouchers::findOne($vou['vid']);//make a typecasting //找一个删一个
                    $voucher->delete();
                }

          		Yii::$app->session->setFlash('success', "Deleted!");
        	}
        }
    	else
    	{
    	   Yii::$app->session->setFlash('warning', "No Voucher/Record was selected!");
    	}
    }

    public function actionMorediscount($vid)
    {
        $voucher = VouchersDiscount::find()->where('vid=:vid',[':vid'=>$vid])->all();
        $discount = new VouchersDiscount();
        $item = ArrayHelper::Map(VouchersDiscountItem::find()->all(),'id','description');
        $type = ArrayHelper::Map(VouchersDiscountType::find()->all(),'id','description');
        foreach ($voucher as $k => $vou) {
            //var_dump($vou);exit;
            unset($item[$vou['discount_item']]);
        }

        if (empty($item)) {
            Yii::$app->session->setFlash('warning', "No selection can be used for this coupon!");
            return $this->redirect(['/vouchers/index']);
        }

        if (Yii::$app->request->post()) {
            $discount->load(Yii::$app->request->post());
            $discount['vid'] = $vou['vid'];
            if ($discount->validate()) {
                $discount->save();
                Yii::$app->session->setFlash('success', "Success!");
            }
            return $this->redirect(['/vouchers/index']);
        }
        
        
        //var_dump($item);exit;
        return $this->render('morediscount',['item'=>$item,'voucher'=>$voucher,'discount'=>$discount,'type'=>$type]);
    }

     //批量制造code
    public function actionGencodes()
    {
		$model = new Vouchers;
        $model->scenario = 'generate'; // set senario, 为了model 的 rule 来判断
		$model->startDate = date('Y-m-d');
        //$model->endDate = date('Y-m-d',strtotime('+30 day'));
        $model->digit = 16;
        $discount = new VouchersDiscount();
        $list = ArrayHelper::map(VouchersDiscountType::find()->all(),'id','description');
        $item = ArrayHelper::map(VouchersDiscountItem::find()->all(),'id','description');
    	if(Yii::$app->request->post())
        {
            $model->load(Yii::$app->request->post());
            $discount->load(Yii::$app->request->post());
        	$valid = self::discountvalid(Yii::$app->request->post(),2);
            if ($valid == false){
                return $this->render('gencodes', ['model' => $model,'list'=>$list,'item'=>$item]);
            }
           
    		$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";//code 包含字母
    		$count = 0;
        	//第一个for 制造code 的数量，第二个for制造code包含16个字母

        	for ($j=1; $j <= $model['amount'] ; $j++) { 
                $model->code='';
           		for($i=0;$i<$model['digit']; $i++){
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
    			$valid =self::createVoucher($model['code'],1,$model['startDate'],$model->endDate,$discount->discount,$discount->discount_type,$discount->discount_item);
        	}
            if ($valid == true) {
                Yii::$app->session->setFlash('success', $model['amount']." Code Generated!");
            }
            else{
                Yii::$app->session->setFlash('warning', "Something went wrong.");
            }
        	
        	return $this->redirect(['vouchers/gencodes']);
    	}

    	return $this->render('gencodes', ['model' => $model,'discount'=>$discount,'list'=>$list,'item'=>$item]);
    	
    }

    public function actionSpecialVoucher()
    {
        $searchModel = new VouchersDiscount();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,2);
        $title = 'Special Voucher';

        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel,'title'=>$title]);
    }

    public function actionSpecadd()
    {
        $model = new Vouchers;
        $discount = new VouchersDiscount;
        $condition = new VouchersSetcondition;
        $model->inCharge = Yii::$app->user->identity->id;
        $model->startDate = date('Y-m-d');
        $list = ArrayHelper::map(VouchersDiscountType::find()->all(),'id','description');
        $item = ArrayHelper::map(VouchersDiscountItem::find()->all(),'id','description');
        $con = ArrayHelper::map(VouchersConditions::find()->all(),'id','description');
        $title = 'New Special Voucher';

        if( Yii::$app->request->post())
        {
            $model->load(Yii::$app->request->post());
            $discount->load(Yii::$app->request->post());
            $condition->load(Yii::$app->request->post());

            $valid = self::discountvalid(Yii::$app->request->post(),1);
            $valid2 = self::conditionvalid($condition['condition_id'],$condition['amount']);
            if ($valid == false || $valid2 == false){
                return $this->render('addvouchers', ['model' => $model,'discount'=>$discount,'list'=>$list,'item'=>$item,'con'=>$con,'condition'=>$condition,'title'=>$title]);
            }

            $model->status = 5;
            if($model->validate()){
                $model->save();
                $discount['vid'] = $model['id'];
                $condition['vid'] = $model['id'];
                if (!empty($condition['condition_id'])) {
                    $condition->save();
                }
                if ($discount->validate()) {
                    $discount->save();
                    Yii::$app->session->setFlash('success', "Created!!");
                }
                else{
                    $model->delete();
                    Yii::$app->session->setFlash('error', "Voucher Create Failed. Discount can't saved.");
                }
                
                return $this->redirect(['/vouchers/specadd']);
            }
            else{
                Yii::$app->session->setFlash('danger', "Unexpected error, please contact IT department");
            }
        }
               
        return $this->render('addvouchers', ['model' => $model,'discount'=>$discount,'list'=>$list,'item'=>$item,'con'=>$con,'condition'=>$condition,'title'=>$title]);
    }

    // code, status, startDate, endDate, discount, discount_type, discount_item
    public static function createVoucher($code,$status=1,$sdate,$edate=0,$disamount,$distype,$disitem)
    {
        $model = new Vouchers;
        $model->inCharge = Yii::$app->user->identity->id;
        $model->code = $code;
        $model->status = $status;
        $model->startDate = $sdate;
        $model->endDate = $edate;
        if ($model->validate()) {
            $model->save();
            $discount = new VouchersDiscount();
            $discount->vid=$model['id'];
            $discount['discount'] = $disamount;
            $discount['discount_type'] = $distype;
            $discount['discount_item'] = $disitem;
            if ($discount->validate()) {
                $discount->save();
                return true;
            }
            else{
                $model->delete();
                return false;
            }
        }
        else{
            return false;
        }
        
    }

    public static function discountvalid($post,$case)
    {
        switch ($case) {
            case 1:
                $check = Vouchers::find()->where('code = :c',[':c'=>$post['Vouchers']['code']])->one();//查询是否重复code
                if (empty($check)) {
                    $valid = self::discountExceed($post['VouchersDiscount']['discount_type'],$post['VouchersDiscount']['discount']);
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
                $valid = self::discountExceed($post['VouchersDiscount']['discount_type'],$post['VouchersDiscount']['discount']);
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

    public static function conditionvalid($cid,$amount)
    {
        switch ($cid) {
            case 1:
                return true;
                break;

            case 2:
                if (empty($amount)) {
                    Yii::$app->session->setFlash('warning','Amount Required for this condition.');
                    return false;
                }
                break;
            
            default:
                return true;
                break;
        }
    }
}
