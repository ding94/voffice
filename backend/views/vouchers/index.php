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

    <?= Html::beginForm(['vouchers/batch'],'post');?>
	<?= Html::a('Add New Voucher', ['/vouchers/add'], ['class'=>'btn btn-success']) ?>
    <?= Html::submitButton('Remove Vouchers',  [
        'class' => 'btn btn-danger', 
        'data' => [
                'confirm' => 'Are you sure want to delete these vouchers?',
                'method' => 'post',
            ]]);?>
        
    <?= Html::a('Generate new Vouchers', ['/vouchers/gencodes'], ['class'=>'btn btn-warning']);?>
    
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
                     [
                        'class' => 'yii\grid\CheckboxColumn',
                       
                    ],
                    [
                        'attribute' => 'id',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search ID',
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
                        'attribute' => 'discount',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Discount',
                        ],
                    ],
                    [
                        'attribute' => 'type',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Discount',
                        ],
                    ],
                    [
                        'attribute' => 'status',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Status',
                        ],
                    ],
                    [
                        'attribute' => 'usedTimes',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Used Times',
                        ],
                    ],
                    [
                        'attribute' => 'inCharge',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Person In Charge',
                        ],
                    ],
    	            'startDate:date',
    	            'endDate:date',
        ]
    ])?>
    <?= Html::endForm();?> 



 