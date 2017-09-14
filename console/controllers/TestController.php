<?php namespace console\controllers; 

use Yii; 
use yii\console\Controller; 
use common\models\User\User;

class TestController extends Controller
{
    
    public function actionIndex()
    {
       $data = User::findOne(10);
       $data->status =0;
       if($data->save(false))
       {
       		echo "Success";
       }
       else
       {
       		echo "Fails";
       }
    }
}