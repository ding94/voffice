<?php

namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Vouchers;


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
        $model->startDate = date('Y-m-d');
        $model->endDate = date('Y-m-d',strtotime('+30 day'));
        var_dump(Yii::$app->user->identity->id);exit;
        if( $model->load(Yii::$app->request->post()))
        {
            $isValid = $model->validate();
            //var_dump($parcel->validate());exit;
           var_dump($model);exit;
            if($isValid)
            {
                $model->save();
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
        
        return $this->render('addvouchers', ['model' => $model]);
    }


}
