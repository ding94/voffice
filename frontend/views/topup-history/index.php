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
<head>
<style>
table, th,td{
	border:10px white;
	padding: 5px;
}
#display td:hover{background-color: #fdf8e4;}
 #display td:active{background-color: #f4d96c;}
</style>
</head>
<div class="container">
	<div class="tab-content col-md-7 col-md-offset-1" >
		
		<h2>My Account History</h2><br>

             <table style="cursor:pointer" class="table table-user-information" id="display">
<tr class="hover" style="text-align: center; height:60px; font-size:20px;">
<td class="warning" onclick="window.document.location='../web/index.php?r=topup-history/index';">Topup History</td>

<td class="info" onclick="window.document.location='../web/index.php?r=withdraw-history/index';">Withdraw History</td>
</tr>	
</table>	
	
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

  
           