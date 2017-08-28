<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use iutbay\yii2fontawesome\FontAwesome as FA;
use kartik\widgets\ActiveForm;


	$this->title = 'User Withdraw';
	$this->params['breadcrumbs'][] = $this->title;
	
?>
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn' ],
                'acc_name',
                'withdraw_amount',
				'to_bank',
				'bank_name',
    	         ],
    ]); ?>