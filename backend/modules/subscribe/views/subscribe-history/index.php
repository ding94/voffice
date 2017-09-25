<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title = 'Subscribe History';
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
           
			[
                    'attribute' =>  'id',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search History ID',
                         ],
       ],
           
			[
                    'attribute' =>  'user.username',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Username',
                         ],
       ],
           
			[
                    'attribute' =>  'amount',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Amount',
                         ],
       ],
            
			[
                    'attribute' => 'package.type',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Package Type',
                         ],
       ],
            
			[
                    'attribute' => 'subscribeType.description',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Subscribe Description',
                         ],
       ],
           
			[                  
                   'attribute' =>  'pay_date',
				 'value' =>  'pay_date',
       			 'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel, 'attribute'=> 'pay_date', 'dateFormat' => 'yyyy-MM-dd',]),
				 'format' => 'html',
          
            ],
                  
			[
                    'attribute' => 'subscribe_period',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Subscribe Period',
                         ],
       ],
			[                  
                'attribute' => 'subscribe_date',
				 'value' =>  'subscribe_date',
       		    'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel, 'attribute'=>'subscribe_date', 'dateFormat' => 'yyyy-MM-dd',]),
				 'format' => 'html',
          
            ],           
		   [                  
                'attribute' => 'end_date',
				 'value' =>  'end_date',
       			 'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel, 'attribute'=> 'end_date', 'dateFormat' => 'yyyy-MM-dd',]),
				 'format' => 'html',
          
            ],  

             ['class' => 'yii\grid\ActionColumn' , 
                'template'=>'{payment} ',
                'buttons' => [
                    'payment' => function($url , $model)
                    {
                        $url = Url::to(['' ,'id'=>$model->id]);
                    
                        return  Html::a(FA::icon('money') , $url , ['title' => '']) ;
                    },
                ]
            ],
        ],
    ]); ?>