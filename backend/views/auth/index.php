<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

    $this->title =  $searchModel->titleName;
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= Html::a('Add Role', ['/auth/add'], ['class'=>'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description',
            'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

