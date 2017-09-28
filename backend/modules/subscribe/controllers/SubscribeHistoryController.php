<?php

namespace backend\modules\subscribe\controllers;

use yii\web\Controller;
use Yii;
use backend\models\SubscribeHistorySearch;

/**
 * Default controller for the `modules` module
 */
class SubscribeHistoryController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$searchModel = new SubscribeHistorySearch;
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index' ,['model' => $dataProvider , 'searchModel' => $searchModel]);
    }
}
