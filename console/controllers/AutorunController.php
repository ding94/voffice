<?php namespace console\controllers; 

use Yii; 
use yii\console\Controller; 
use common\models\User\UserPackage;

class AutorunController extends Controller
{
    
    public function actionUsersubscription()
    {
       $subscription = UserPackage::find()->all();
       foreach ($subscription as $key => $value) {
          $value->sub_period  -= 1;
          if($value->save(false))
          {
            echo "Success";
          }
          else
          {
            echo "Fail";
          }
       }
    }
}