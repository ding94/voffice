<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title = 'Add Mail';
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
                        $url = Url::to(['parcel/new-mail' ,'id'=>$model->id]);
                    
                        return  Html::a(FA::icon('plus') , $url , ['title' => 'add user mail or parcel']) ;
                    },
                ]
            ],
            [
                'attribute' => 'username',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Username',
                ],
            ],
            [
                'label' => 'Full Name',
                'attribute' => 'userdetail.fullname',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Full Name',
                ],
            ],
            [
                'attribute' => 'email',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Email',
                ],
            ],
            [
                'attribute' => 'usercompany.cmpyName',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Company Name',
                ],
            ],
        ],
    ]); ?>