<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use iutbay\yii2fontawesome\FontAwesome as FA;
use kartik\widgets\ActiveForm;
use backend\models\Admin;

	$this->title = 'User Withdraw';
	$this->params['breadcrumbs'][] = $this->title;
	
?>
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'showFooter'=>true,

        'columns' => [
	        ['class' => 'yii\grid\ActionColumn',
				'template'=>'{approve} ',
	            'header' => "Approve",
				'buttons' => [
	            'approve' => function($url , $model){
						
	                    $url = Url::to(['withdraw/approve' ,'id'=>$model->id,'admin'=>Yii::$app->user->identity->id]) ;
	                    return Html::a(FA::icon('check lg') , $url , ['title' => 'Approve','data-confirm'=>"Confirm action?"]);
						
					},
	            ]
			],
			
			['class' => 'yii\grid\ActionColumn' , 
	            'template'=>'{cancel} ',
	            'header' => "Reject",
				'buttons' => [
	            'cancel' => function($url , $model){
						
	                	$url = Url::to(['withdraw/cancel' ,'id'=>$model->id]) ;
	                    return Html::a(FA::icon('ban lg') , $url , ['title' => 'Reject','data-confirm'=>"Confirm action?"]);
						
					},
	            ]
			],

			[
                'attribute' => 'acc_name',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Account Name',
                ],
            ],

            [
                'attribute' => 'withdraw_amount',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Amount',
                ],
            ],

            [
                'attribute' => 'to_bank',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Bank Acount',
                ],
            ],
			 [
                    'attribute' => 'bankdetails.bank_name',
					
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Bank Name',
                         ],
						
                    ],
            

			[
				'label' => 'Status',
				'format' => 'raw',
				'headerOptions' => ['width' => "15px"],
				'contentOptions' => ['style' => 'font-size:20px;'],
				'attribute' => 'offlinetopupstatus.title',
				'value' => function($model){
					return Html::tag('span' , $model->offlinetopupstatus->title ,['class' => $model->offlinetopupstatus->labelName ]);
				},

				'filter' => $list,
			],
			
			[ 	'label' => 'In Charge',
					'attribute' => 'inCharge',
					'value'=> function($model){
						$name ="";
						if(!empty($model->inCharge))
						{
							$name = Admin::findOne($model->inCharge)->adminname;
						}
						return $name;
                    
					},
				
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Person in Charge',
                     ],
            ],

            [
                'attribute' => 'reason',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Reason',
                ],
            ],
		],
               
    	         
    ]); ?>