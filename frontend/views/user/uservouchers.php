<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use iutbay\yii2fontawesome\FontAwesome as FA;
use backend\models\Vouchers;

?>
<div class="uservoucher">
    <div id="userprofile" class="row">
       <div class="userprofile-header">
            <div class="userprofile-header-title">User Voucher</div>
        </div>
        <div class="topup-detail">
            <div class="col-sm-2" style="padding-bottom:20px;">
            </div>
            <div class="col-sm-10 right-side">
                <?= Html::beginForm(['vouchers/batch'],'post');?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                       [
                        'class' => 'yii\grid\SerialColumn',

                    ],
                    'vid',
                    'code',
                    'limitedTime',
                    [
                        'attribute' => 'voucher',
                        //'value' => 'vouchers.discount',
                        'value' => function($model)
                        {
                            $vou = Vouchers::find()->where('id = :id',[':id'=>$model->vid])->one();
                            if ($vou->discount_type == 1) {
                                return $vou->discount.'%';
                            }
                            elseif ($vou->discount_type == 2) {
                                return 'RM'.$vou->discount;
                            }
                            else
                            {
                                return 'error';
                            }
                        },
                        'label' => 'Discount',
                    ],
                    [
                        'attribute' => 'item',
                        'value' => function($model)
                        {
                            $vou = Vouchers::find()->where('id = :id',[':id'=>$model->vid])->one();
                            switch ($vou->discount_item) {
                                case 1:
                                return 'Total';
                                break;
                                case 2:
                                return 'Purchase';
                                break;
                                case 3:
                                return 'Service Charge';
                                break;
                                case 4:
                                return 'First Purchase';
                                break;

                                default:
                                return 'error';
                                break;
                            }
                        },
                        'label' => 'Discount from',
                    ],
                ]
                ])?>
                <?= Html::endForm();?> 
            </div>
        </div>
    </div>
</div>


 