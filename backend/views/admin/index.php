<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;

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
                'authAssignment.item_name',
            ['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{update} {active} {delete}',
             'buttons' => [
                'active' => function($url , $model)
                {
                    $url = Url::to(['admin/active' ,'id'=>$model->id]);
                    return Html::a(FA::icon('toggle-on') , $url , ['title' => 'active']);
                },
              ]
            ],
        ],
    ]); ?>
</div>
