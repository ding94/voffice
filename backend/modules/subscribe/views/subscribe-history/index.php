<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title = 'Subscribe History';
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'user.username',
            'amount',
            'package.type',
            'subscribeType.description',
            'pay_date',
            'subscribe_period',
            'subscribe_date',
            'end_date',
             ['class' => 'yii\grid\ActionColumn' , 
                'template'=>'{payment} ',
                'buttons' => [
                    'payment' => function($url , $model)
                    {
                        $url = Url::to(['' ,'id'=>$model->id]);
                    
                        return  Html::a(FA::icon('money') , $url , ['title' => '']) ;
                    },
                ]
            ],
        ],
    ]); ?>