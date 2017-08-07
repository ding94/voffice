<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title = 'Received Mail';
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn' , 
                'template'=>'{add} ',
                'buttons' => [
                    'add' => function($url , $model)
                    {
                        $url = Url::to(['parcel/add-mail' ,'id'=>$model->id]);
                    
                        return  Html::a(FA::icon('plus') , $url , ['title' => 'add user mail or parcel']) ;
                    },
                ]
            ],
            'username',
            [
                'label' => 'Full Name',
                'attribute' => 'userdetails.fullname',
            ],
            'email',
            'usercompany.cmpyName',
        ],
    ]); ?>