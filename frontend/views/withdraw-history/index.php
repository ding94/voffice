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

<div class="balance">
    <div id="userprofile" class="row">
       <div class="userprofile-header">
            <div class="userprofile-header-title">Account History</div>
        </div>
        <div class="topup-detail">
            <div class="col-sm-2" style="padding-bottom:20px;">
                <div class="nav-url">
                  <ul class="nav nav-pills nav-stacked">
                      <li role="presentation"><?php echo Html::a('Account Balance',['user/userbalance'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation" class="active"><a href="#" class="btn-block userprofile-edit-left-nav">Account History</a></li>
                      <li role="presentation"><?php echo Html::a('Top Up',['topup/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation"><?php echo Html::a('Withdraw',['withdraw/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                  </ul>
                </div>
            </div>
            <div class="col-sm-10 right-side" id="withdraw-history-container">
                <table class="table table-user-information" id="display">
					<tr>
						<td id="topup" onclick="window.document.location='../web/index.php?r=topup-history/index';">Topup History</td>
						<td id="withdraw">Withdraw History</td>
					</tr>	
                </table>    
                <?= GridView::widget([
                	'dataProvider' => $model,
                	'filterModel' => $searchModel,
                	'columns' => [
	                		[
	                			'attribute' => 'withdraw_amount',
	                			'filterInputOptions' => [
	                				'class'       => 'form-control',
	                				'placeholder' => 'Search Amount',
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
	                			'attribute' => 'reason',
	                			'filterInputOptions' => [
	                				'class'       => 'form-control',
	                				'placeholder' => 'Search Reason',
	                			],
	                		],
	                	],
                	]); ?>
            </div>
        </div>
    </div>
</div>