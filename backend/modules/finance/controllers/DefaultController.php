<?php

namespace backend\modules\finance\controllers;

use yii\web\Controller;
use common\models\User\User;
use common\models\User\UserBalance;

/**
 * Default controller for the `finance` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public static function getAccountBalance($id,$type,$balance)
    {
    	$uid = User::find()->where("id = :id",[':id' => $id])->one()->id;
    	//var_dump($username);exit;
    	$data =UserBalance::find()->where('uid = :uid',[':uid'=>$uid])->one();
    	$data->balance += $balance;

    	if($type == 0)
    	{
    		$data->positive += $balance;
    	}
    	else
    	{
    		$data->negative -= $balance;
    	}
    	return $data;
    }
}
