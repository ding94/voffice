<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

    $this->title =  'User List';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title)?></h1>
    <?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'item_name',
            'user_id',
            'created_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
