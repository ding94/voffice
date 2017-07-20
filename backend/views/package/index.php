<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

	$this->title = 'Package List';
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<h1><?= Html::encode($this->title)?></h1>
	<?= Html::a('Add New Package', ['/package/add'], ['class'=>'btn btn-success']) ?>
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
        
            ['class' => 'yii\grid\SerialColumn'],

            'type',
	        'price',

            ['class' => 'yii\grid\ActionColumn' , 'template'=>'{update} {delete}' ],
        ],
    ]); ?>
</div>
