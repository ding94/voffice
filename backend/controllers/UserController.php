<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User\User;
use common\models\User\UserSearch;
use common\models\Parcel\Parcel;
use common\models\Parcel\ParcelSearch;
use common\models\User\UserVoucher;
use backend\models\Vouchers;
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
		if ( $uservoucher->load(Yii::$app->request->post())) {
			
			$uservoucher->uid =  $id;
			$uservoucher->vid = Vouchers::find()->where('code = :c', [':c'=>Yii::$app->request->post('UserVoucher')['code']])->one();
			$voucher->discount = Yii::$app->request->post('Vouchers')['discount'];
			
			if (empty($uservoucher->vid) && empty($voucher->discount)) {
					Yii::$app->session->setFlash('error', "Failed! Voucher not found or discount no given!");
			}

			elseif (empty($uservoucher->vid) && !empty($voucher->discount)) {
				
				$voucher->code = Yii::$app->request->post('UserVoucher')['code'];
				$voucher->discount = $voucher->discount;
				$voucher->inCharge = Yii::$app->user->identity->adminname;
				$voucher->startDate = date('Y-m-d');
				$voucher->endDate = Yii::$app->request->post('UserVoucher')['limitedTime'];
				$voucher->status = 1;
				$voucher->save();
				
				$uservoucher->code = Yii::$app->request->post('UserVoucher')['code'];
				$uservoucher->vid = Vouchers::find()->where('code = :c', [':c'=>$uservoucher->code])->one()->id;
				$uservoucher->save();
				Yii::$app->session->setFlash('success', "Success! Voucher created to User: ".User::find()->where('id = :id', [':id'=>$id])->one()->username);
				return $this->redirect(['uservoucherlist']);
			}

			elseif (!empty($uservoucher->vid)) {

				if ($uservoucher->vid['status'] == 0) {
					$uservoucher->code = Yii::$app->request->post('UserVoucher')['code'];
					$uservoucher->vid = Vouchers::find()->where('code = :c', [':c'=>$uservoucher->code])->one()->id;
					$voucher = Vouchers::find()->where('code = :c', [':c'=>Yii::$app->request->post('UserVoucher')['code']])->one();
					$voucher->status = 1;

					if ($uservoucher->validate() && $voucher->validate()) {
						$voucher->save();
						$uservoucher->save();
					}
					
					Yii::$app->session->setFlash('success', "Success gave code to User: ".User::find()->where('id = :id', [':id'=>$id])->one()->username);
					return $this->redirect(['uservoucherlist']);
				}
				elseif ($uservoucher->vid['status'] != 0) {
					Yii::$app->session->setFlash('error', "Used Voucher!");
				}
				elseif($uservoucher->validate() == false )
				{
					Yii::$app->session->setFlash('error', "Somthing went wrong! Contact IT department!");
				}
				
			}
		}
		return $this->render('addvoucher',['uservoucher' => $uservoucher, 'dataProvider' => $dataProvider, 'voucher' => $voucher , 'searchModel'=> $searchModel]);
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