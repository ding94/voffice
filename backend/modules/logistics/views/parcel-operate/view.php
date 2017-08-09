<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

    $this->title = 'View Operate';
    $this->params['breadcrumbs'][] = $this->title;
?>
   
    <?= GridView::widget([

        'dataProvider' => $model,
        'columns' => [
           'adminname',
           'oldVal',
           'newVal',
           'updated_at:datetime',
        ],
    ]); ?>


   