<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

    $this->title = 'Notification Record';
    $this->params['breadcrumbs'][] = $this->title;
?>
    <?= GridView::widget([

        'dataProvider' => $model,
        'columns' => [
           'content',
           [
                'attribute'  => 'updated_at',
                'value' => function($model)
                {
                    return Yii::$app->formatter->format($model->updated_at, 'relativeTime');
                }    
           ]
        ],
    ]); ?>


   