<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use iutbay\yii2fontawesome\FontAwesome as FA;

	$this->title = 'Vouchers List';
	//$this->params['breadcrumbs'][] = $this->title;
?>

	<?= Html::a('Add New Voucher', ['/vouchers/add'], ['class'=>'btn btn-success']) ?>
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [

    	            'id',
    	            'code',
    	            'discount',
    	            'status',
    	            'usedTimes',
    	            'inCharge',
    	            'startDate:date',
    	            'endDate:date',
        ]
    ])?>