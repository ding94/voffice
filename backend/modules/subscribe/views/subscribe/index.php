<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;
use common\models\SubscribeType;

    $this->title = 'User Subscribe List';
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
		[
                    'attribute' => 'uid',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search User ID',
                         ],
                    ],
         [
                    'attribute' => 'packid',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Package ID',
                         ],
                    ],
		 [
                    'attribute' => 'code',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Code',
                         ],
                    ],
           
		    [ 	'label' => 'Subscription Type',
					'attribute' => 'type',
					'value'=> function($model){
						$name ="";
						if(!empty($model->type))
						{
							$name = SubscribeType::findOne($model->type)->description;
						}
						return $name;
                    
					},
				
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Subscription Type',
                     ],
            ],
		 
		
			  [
                    'attribute' => 'subscribe_time',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Subscription Time',
                         ],
                    ],
			  [
                    'attribute' => 'end_period',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search End Period',
                         ],
                    ],
					
			 [
                    'attribute' => 'sub_period',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Sub Period',
                         ],
                    ],
            [
                    'attribute' => 'userpackagesubscription.next_payment',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Sub Period',
                         ],
                    ],
           
        /*     ['class' => 'yii\grid\ActionColumn' , 
                'template'=>'{edit} ',
                'buttons' => [
                    'edit' => function($url , $model)
                    {
                        $url = Url::to(['' ,'id'=>$model->id]);
                    
                        return  Html::a(FA::icon('pencil') , $url , ['title' => '']) ;
                    },
                ]
            ], */
        ],
    ]); ?>