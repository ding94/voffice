<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use common\models\vouchers\{VouchersStatus,VouchersDiscount,VouchersDiscountType,VouchersDiscountItem};
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
                        'value' => 'voucher.code',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Code',
                        ],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn' ,
                        'template'=>'{morediscount}',
                        'buttons' => [
                            'morediscount' => function($url,$model)
                            {
                                return Html::a("Add discount" ,['vouchers/morediscount','vid'=>$model['vid']], ['title' => 'Add more discount item to this voucher']);
                            },
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
                        'attribute' => 'discount_type',
                        'value' => function($model)
                        {
                            $model->discount_type = VouchersDiscountType::find()->where('id=:id',[':id' => $model->discount_type])->one()->description;
                            return $model->discount_type;
                        },
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Discount',

                        ],
                        'filter' => array( "1"=>"Discount by %","2"=>"Discount by amount"),
                    ],
                    [
                        'attribute' => 'discount_item',
                        'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Discount',

                        ],
                        'filter' => array( "1"=>"Discount by %","2"=>"Discount by amount"),
                    ],
                    [
                        'attribute' => 'vouchers.status',
                        'value' => function($model)
                        {
                            //var_dump($model);exit;
                            $status = VouchersStatus::find()->where('id=:id',[':id' => $model['voucher']['status']])->one()->description;
                            return $status;
                            
                        },
                        'filter' => array( "1"=>"Actived","2"=>"Assigned","3"=>"Used","4"=>"Expired"),
                    ],
                    /*[
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
                    ],*/
    	            'voucher.startDate:date',
    	            'voucher.endDate:date',
        ]
    ])?>
    <?= Html::endForm();?> 



 