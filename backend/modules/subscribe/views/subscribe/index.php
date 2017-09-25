<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;
use common\models\SubscribeType;
use common\models\Package;
    $this->title = 'User Subscribe List';
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
		[
                    'attribute' => 'user.username',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Username',
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
                    'attribute' => 'code',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Code',
                         ],
                    ],
           [
                    'attribute' => 'subscribetype.description',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Subscribe Description',
                         ],
       ],
		
			  [                  
                 'attribute' => 'subscribe_time',
				 'value' => 'subscribe_time',
       			 'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel, 'attribute'=>'subscribe_time', 'dateFormat' => 'yyyy-MM-dd',]),
				 'format' => 'html',
          
            ],
                    
			  
			 [                  
                 'attribute' => 'end_period',
				 'value' => 'end_period',
       			 'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel, 'attribute'=>'end_period', 'dateFormat' => 'yyyy-MM-dd',]),
				 'format' => 'html',
          
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
					 'value' => 'userpackagesubscription.next_payment',
                     'filter' => \yii\jui\DatePicker::widget(['model'=>$searchModel, 'attribute'=>'userpackagesubscription.next_payment', 'dateFormat' => 'yyyy-MM-dd',]),
				 'format' => 'html',
                    ],
           
		],
    ]); ?>