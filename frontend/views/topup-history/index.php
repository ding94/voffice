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

	$this->title = 'My Account History';
	$this->params['breadcrumbs'][] = $this->title;
	
?>
<div class="container">
	<div class="tab-content col-md-7 col-md-offset-1" >
		<h1>My Account History</h1>

                
 <?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
		
			
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
					
              
					
                    [
                    'attribute' => 'rejectReason',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Reason',
                         ],
                    ],
					
					  ],])?>
					  
					  
	</div>
</div>

  
           