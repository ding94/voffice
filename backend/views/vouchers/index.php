<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use iutbay\yii2fontawesome\FontAwesome as FA;

	$this->title = 'Voucher List';
	$this->params['breadcrumbs'][] = $this->title;
?>

    <?=Html::beginForm(['vouchers/batch'],'post');?>
	<?= Html::a('Add New Voucher', ['/vouchers/add'], ['class'=>'btn btn-success']) ?>
    <?=Html::submitButton('Generate 10 new Vouchers', ['name'=>'gen', 'value' => 'gen','class' => 'btn btn-danger',]);?>

    <?=Html::submitButton('Remove Vouchers', ['name'=>'remove', 'value' => 'remove','class' => 'btn btn-danger',]);?>
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
                     [
                        'class' => 'yii\grid\CheckboxColumn',
                       
                    ],
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
    <?= Html::endForm();?> 
 