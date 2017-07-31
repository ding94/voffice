<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\UserDetails;
use common\models\UserParcel;
use common\models\ParcelDetail;
use backend\models\Admin;
Class UserController extends Controller
{
	public function actionIndex()
	{
		$searchModel = new User();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 
        return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}

	public function actionView($id)
	{
		$model = $this->findModel($id);
        
        $parcel = UserParcel::find()->where('uid = :id' ,[':id' => $id])->all();
        if(!empty($parcel)) {

             return $this->render('view',['model' => $model, 'pid'=>$parcel]);
             
        }
        else{
            return $this->render('view',['model' => $model]);
        }
		
	}

    
    
    public function actionUserParcel()
    {
        $searchModel = new UserDetails();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //var_dump($searchModel);exit;
        return $this->render('userparcel',['model' => $dataProvider , 'searchModel' => $searchModel]);

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

    public function actionAdd($id,$admin)
    {
        // action to add parcel， 加包裹

        $model = new UserParcel;
        $parcel = new ParcelDetail;
        $user = UserDetails::findOne($id);
        $model->uid = $user->uid;
        $model->arrived_time = date('Y-m-d');
        $parcel->signer = Yii::$app->user->identity->adminname;
        if( $model->load(Yii::$app->request->post()) &&  $parcel->load(Yii::$app->request->post()))
        {
            $isValid = $model->validate();
            //var_dump($parcel->validate());exit;
            $isValid = $parcel->validate() && $isValid;
           /* var_dump($isValid);exit;*/
            if($isValid)
            {
                $model->save();
                $parcel->parid = $model->id;
                $parcel->save();
                Yii::$app->session->setFlash('success', "Update completed");
            }
            else
            {
                Yii::$app->session->setFlash('Warning', " completed");
            }
        }
               
           

           /* if($model->load(Yii::$app->request->post())  )
            }
            }
            {
                $parcel->parid = $model->id;
                $parcel->signer = Admin::findOne($admin)->adminname;
                $parcel->save();
                Yii::$app->session->setFlash('success', "Update completed");
                return $this->redirect(['user/user-parcel']);
            }*/
        
        return $this->render('addparcel', ['model' => $model , 'parcel' => $parcel, 'user' => $user]);
    }


}