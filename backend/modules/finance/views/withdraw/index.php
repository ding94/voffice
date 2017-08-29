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
            ['class' => 'yii\grid\ActionColumn',
			'template'=>'{approve} ',
             'header' => "Approve",
			 'buttons' => [
             'approve' => function($url , $model){
				
                   
                    return Html::a(FA::icon('check lg') , $url , ['title' => 'approve','data-confirm'=>"Confirm action?"]);

					},
            ]
			],
			
			['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{cancel} ',
             'header' => "Reject",
			 'buttons' => [
             'cancel' => function($url , $model){
					
                   
                    return Html::a(FA::icon('ban lg') , $url , ['title' => 'cancel','data-confirm'=>"Confirm action?"]);
					
					},
            ]
			],
			
			    'acc_name',
                'withdraw_amount',
				'to_bank',
				'bank_name',
			],
               
    	         
    ]); ?>