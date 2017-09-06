<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\models\User\User;
use common\models\User\UserSearch;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelSearch;
use common\models\User\UserVoucher;
use backend\models\Vouchers;
use backend\models\VouchersStatus;
use backend\models\Admin;
use backend\modules\logistics\controllers\ParcelStatusNameController;
Class UserController extends CommonController
{
	public function actionIndex()
	{
		$searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}

	public function actionView($id)
	{
		$user = User::find()->where('id = :id',[':id' => $id])->joinwith('userdetail')->one();
		
		$searchModel = new ParcelSearch;
		$dataProvider = $searchModel->searchparceldetail(Yii::$app->request->queryParams,$id);

		$list = ParcelStatusNameController::listStatus();
		
        return $this->render('view',['user' => $user ,'dataProvider' => $dataProvider , 'searchModel'=> $searchModel ,'list' => $list]);
		
	}
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->status = 0;
		if($model->update(false) !== false)
		{
			Yii::$app->session->setFlash('warning', "Delete completed");
		}
		else{
			Yii::$app->session->setFlash('warning', "Fail to delete");
		}
       return $this->redirect(Yii::$app->request->referrer);
	}

	public function actionActive($id)
	{
		$model = $this->findModel($id);
		$model->status = 10;
		if($model->update(false) !== false)
		{
			Yii::$app->session->setFlash('success', "Active completed");
		}
		else{
			Yii::$app->session->setFlash('warning', "Fail to Active");
		}
        return $this->redirect(['index']);

	}

	public function actionUservoucherlist()
	{
		$searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('uservoucherlist',['model' => $dataProvider , 'searchModel'=> $searchModel ]);

	}

	public function actionAddvoucher($id)
	{
		$searchModel = new Vouchers();
        $dataProvider = $searchModel->searchvalid(Yii::$app->request->queryParams);

        $voucher = new Vouchers();
		$uservoucher = new UserVoucher;
		$uservoucher->limitedTime = date('Y-m-d',strtotime('+30 day'));

        $list = ArrayHelper::map(VouchersStatus::find()->where(['or',['id'=>1],['id'=>4]])->all(),'id','type');

		if ( $uservoucher->load(Yii::$app->request->post())) 
		{
			
			$valid = self::discountvalid(Yii::$app->request->post());
			
			if ($valid) 
			{
				return $this->redirect(['addvoucher','id'=>$id]);
			}

			$uservoucher->uid = $id;
			$uservoucher->vid = Vouchers::find()->where('code = :c', [':c'=>Yii::$app->request->post('UserVoucher')['code']])->one();

			$voucher->load(Yii::$app->request->post());
			$voucher->type = $list[$voucher->status];
			
			if (empty($uservoucher->vid) && empty($voucher->discount)) 
			{
					Yii::$app->session->setFlash('error', "Failed! Voucher not found or discount no given!");
			}

			elseif (empty($uservoucher->vid) && !empty($voucher->discount)) 
			{
				
				$voucher = self::actionNewvoucher($voucher, Yii::$app->request->post('UserVoucher'));
				if ($voucher->validate()) 
				{
					$voucher->save();
				}

				$uservoucher = self::actionUservoucher($uservoucher, Yii::$app->request->post('UserVoucher'));
				
				if ($uservoucher->validate()) 
				{
					$uservoucher->save();
				}


				Yii::$app->session->setFlash('success', "Success! Voucher created to User: ".User::find()->where('id = :id', [':id'=>$id])->one()->username);
				return $this->redirect(['uservoucherlist']);
			}

			elseif (!empty($uservoucher->vid)) 
			{
				//var_dump($uservoucher->vid['status'] );exit;
				if ($uservoucher->vid['status'] == 1 || $uservoucher->vid['status'] == 4) 
				{
					$uservoucher = self::actionUservoucher($uservoucher, Yii::$app->request->post('UserVoucher'));
					$voucher = self::actionExistvoucher($voucher,$list);
					
					if ($uservoucher->validate() && $voucher->validate()) 
					{
						$voucher->save();
						$uservoucher->save();
					}
					
					Yii::$app->session->setFlash('success', "Success gave code to User: ".User::find()->where('id = :id', [':id'=>$id])->one()->username);
					return $this->redirect(['uservoucherlist']);
				}

				elseif ($uservoucher->vid['status'] != 1 || $uservoucher->vid['status'] != 4) 
				{
					Yii::$app->session->setFlash('error', "Used Voucher!");
				}

				elseif($uservoucher->validate() == false )
				{
					Yii::$app->session->setFlash('error', "Somthing went wrong! Contact IT department!");
				}
				
			}
		}
		return $this->render('addvoucher',['uservoucher' => $uservoucher, 'voucher' => $voucher, 'list' => $list, 'dataProvider' => $dataProvider , 'searchModel'=> $searchModel]);
	}


	public static function discountvalid($post)
	{

		if (Vouchers::find()->where('code = :c', [':c'=>$post['UserVoucher']['code']])->one() == false) {

		if ($post['Vouchers']['status'] == 1) {
				if ($post['Vouchers']['discount']<=0 || $post['Vouchers']['discount'] >= 100) {
					Yii::$app->session->setFlash('error', "Failed, discount not given or exceed limit!");
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

	public function actionNewvoucher($voucher, $post)
	{


		$voucher->status +=1; 
		$voucher->code = $post['code'];
		$voucher->inCharge = Yii::$app->user->identity->adminname;
		$voucher->startDate = date('Y-m-d');
		$voucher->endDate = $post['limitedTime'];

		return $voucher;
				
	}

	public function actionUservoucher($uservoucher, $post)
	{
		$uservoucher->code = $post['code'];
		$uservoucher->vid = Vouchers::find()->where('code = :c', [':c'=>$uservoucher->code])->one()->id;

		return $uservoucher;
	}

	public function actionExistvoucher($voucher,$list)
	{
		$voucher = Vouchers::find()->where('code = :c', [':c'=>Yii::$app->request->post('UserVoucher')['code']])->one();
		$voucher->type = $list[$voucher->status];
		$voucher->status +=1;
		
		return $voucher;
	}





	/**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}