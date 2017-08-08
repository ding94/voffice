<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title = $searchModel->titlename;
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn',],
            'id',
            [
                'attribute' => 'user.username',
                'label' => 'User Name',
            ],
            [
                'attribute' => 'user.userdetail.fullname',
                'label' => 'Full Name',
            ],

            'parceldetail.sender',
            'parceldetail.signer',
            [
                'attribute' => 'type',
                'value' => function($model)
                {
                    return $model->type ==1 ? 'Mail' : 'Parcel';
                },
                'filter' => array( "1"=>"Mail","2"=>"Parcel"),

            ],
            ['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{message} {operate} {next} ',
             'buttons' => [
                'message' => function($url , $model)
                {
                    $url = "";
                    
                    return  Html::a(FA::icon('comments') , $url , ['title' => 'View message']) ;
                },
                'operate' => function($url , $model)
                {
                    $url = Url::to(['parcel/view-operate' ,'id'=>$model->id]);
                    
                    return  Html::a(FA::icon('eye') , $url , ['title' => 'View Operate']) ;
                },
                'next' => function($url , $model)
                {
                    $url =  Url::to(['parcel/next-step' ,'id'=>$model->id,'status'=>$model->status]);
                    
                    return  Html::a(FA::icon('check') , $url , ['title' => 'Next Step']) ;
                },
              ]
            ],
        ],
    ]); ?>