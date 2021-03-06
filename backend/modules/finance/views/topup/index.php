<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use iutbay\yii2fontawesome\FontAwesome as FA;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Admin;

	$this->title = 'Offline Topup';
	$this->params['breadcrumbs'][] = $this->title;
	
?>
		  <?=Html::beginForm(['/finance/topup/direct'],'post');?>
		 
		  <?=Html::submitButton('Pending', ['name'=>'action', 'value' => '1','class' => 'btn btn-info',]);?>
		   <?=Html::submitButton('Success', ['name'=>'action', 'value' => '3','class' => 'btn btn-success',]);?>
		  <?=Html::submitButton('Rejected', ['name'=>'action', 'value' => '4','class' => 'btn btn-danger',]);?>
		 
		   <?=Html::submitButton('All', ['name'=>'action', 'value' => '0','class' => 'btn btn-primary',]);?>
	<?= Html::endForm();?> 
	
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
			 
			  ['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{update} ',
             'header' => "Approve",
			 'buttons' => [
             'update' => function($url , $model){
				if($model->action == 3)
                    {
                         $url = Url::to(['topup/undos','id'=>$model->id,'admin'=>Yii::$app->user->identity->id]);
                    }
                    else
                    {
                        $url = Url::to(['topup/update' ,'id'=>$model->id]) ;
                    }
                   
                    return  $model->action !=3  ? Html::a(FA::icon('check lg') , $url , ['title' => 'Approve','data-confirm'=>"Confirm action?"]) : Html::a(FA::icon('undo lg') , $url , ['title' => 'Reverse Approve','data-confirm'=>"Confirm action?"]);

					},
            ]
			],
			
			 ['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{cancel} ',
             'header' => "Reject",
			 'buttons' => [
             'cancel' => function($url , $model){
					if($model->action == 4)
                    {
                         $url = Url::to(['topup/undo','id'=>$model->id,'admin'=>Yii::$app->user->identity->id]);
                    }
                    else
                    {
                        $url = Url::to(['topup/cancel' ,'id'=>$model->id]) ;
                    }
                   
                    return  $model->action !=4  ? Html::a(FA::icon('ban lg') , $url , ['title' => 'Reject','data-confirm'=>"Confirm action?"]) : Html::a(FA::icon('undo lg') , $url , ['title' => 'Reverse Reject','data-confirm'=>"Confirm action?"]);
					
					},
            ]
			],
		
	
	
			['class' => 'yii\grid\ActionColumn' , 
             'template'=>' {img}',
             'buttons' => [
                

                   /* {
                       $url = Url::to(['topup/update','id'=>$model->id]);//创建链接，带着uid值
                        return   Html::a(FA::icon('check fw') ,$url , ['title' ,'update']);//图案，链接，不知知道干嘛的
                    },*/
					
				

				   /*{
                       $url = Url::to(['topup/cancel','id'=>$model->id,'admin'=>Yii::$app->user->identity->id]);//创建链接，带着uid值
                        return   Html::a(FA::icon('ban fw') ,$url , ['title' ,'cancel']);//图案，链接，不知知道干嘛的
                    },*/
					
				'img' => function($url,$model)
                {

                    return Html::a('Picture',Yii::$app->urlManagerFrontEnd->baseUrl.'/'.$model->picture,['target'=>'_blank']); //open page in new tab
                
                },
				
              ],
			 ],
			
			[
                    'attribute' => 'id',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search ID',
                         ],
                    ],
                                
				   [
                    'attribute' => 'uid',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search User ID',
                         ],
                    ],
                    [
                    'attribute' => 'amount',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Amount',
                         ],
                    ],
                    [
                    'attribute' => 'description',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Description',
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
                    'attribute' => 'rejectReason',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Reason',
                         ],
                    ],
					 //'picture',
					 
				['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{edit} ',
             'header' => "Edit",
             'buttons' => [
                'edit' => function($url , $model)
                {
                   $url = Url::to(['topup/edit','id'=>$model->id,'admin'=>Yii::$app->user->identity->id]);
                    
                   return $model->action ==1  ? Html::a(FA::icon('pencil lg') , $url , ['title' => 'Edit']) : "";
                },
              ]
            ],
			
			['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{operate} ',
             'header' => "View",
             'buttons' => [
                'operate' => function($url , $model)
                {
                   
					$url =  Url::to(['topup/view-operate' ,'tid'=>$model->id,'status'=>$model->action]);
                   return Html::a(FA::icon('eye lg') , $url , ['title' => 'View Operation Record']);
                },
              ]
            ],
			
					
        ],
		
		
    ])?>
	