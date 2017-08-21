<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title =  'User Vouchers  List';
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [

            'username',
            'email',
			['class' => 'yii\grid\ActionColumn' ,
             'template'=>'{addvoucher}',
             'buttons' => [
                'addvoucher' => function($url , $model)
                {
                    return  Html::a(FA::icon('gift 3x') , $url , ['title' => 'Give Voucher']);
                },
              ]
            ],
        ],
    ]); ?>

