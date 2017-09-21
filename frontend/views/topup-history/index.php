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
	border:1px solid #ddd;
	padding: 5px;
}

#display td{
	border-bottom:hidden;	
}

.withdraw{
	td:hover{background-color: #fdf8e4;}
}
 #display td:active{background-color: #f4d96c;}
 
</style>
</head>
<div class="container">
	<div class="tab-content col-md-7 col-md-offset-1" >
		
		<h2>My Account History</h2><br>

             <table class="table table-user-information" id="display">
<tr style="text-align: center; height:60px; font-size:20px;">
<td  style="-webkit-box-shadow: -3px -3px 5px -3px black; border-bottom: hidden;" >Topup History</td>	

<td id = "withdraw" style="cursor:pointer; -webkit-box-shadow: inset 3px -3px 5px -3px black;"onclick="window.document.location='../web/index.php?r=withdraw-history/index';">Withdraw History</td>
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

  
           