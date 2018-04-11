<?php

namespace frontend\controllers;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;

Class CommonController extends Controller
{
	 public static function createUrlLink($type)
    {
        switch ($type) {
            case 1:
                $data = [
                            Url::to(['/parcel/index']) =>'All',
                            Url::to(['/parcel/index','status'=>1]) => 'Received Mail',
                            Url::to(['/parcel/index','status'=>2]) => 'Pending Pickup',
                            Url::to(['/parcel/index','status'=>3]) => 'Sending',
                            Url::to(['/parcel/index','status'=>4]) => 'Confirm received',
                            Url::to(['/parcel/index','status'=>5]) => 'Early postal',
                            Url::to(['/parcel/index','status'=>6]) => 'Pending early pickup',
                        ];
                break;

            default:
                $data =[];
                break;  
        }    
        
        return $data;
    }

}
