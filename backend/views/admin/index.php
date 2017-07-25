<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

	$this->title = 'Admin List';
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<h1><?= Html::encode($this->title)?></h1>
	<?= Html::a('Add New Admin', ['/admin/add'], ['class'=>'btn btn-success']) ?>
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'adminname',
            'email',
	        [
                'attribute' => 'status',
                'value' => function($model)
                {
                    return $model->status ==10 ? 'Active' : 'Inactive';
                }
            ],
            ['class' => 'yii\grid\ActionColumn' , 'template'=>'{update} {delete}' ],
        ],
    ]); ?>
</div>
