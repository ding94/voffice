<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

    $this->title =  'User List';
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'username',
             'fullname.Fname',

             [  'label' => 'Full Name',
             
                'value' => 'fullname.Lname',
            ],
            'email',
            'status',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

