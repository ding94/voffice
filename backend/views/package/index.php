<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;
	$this->title = 'Package List';
	$this->params['breadcrumbs'][] = $this->title;
?>

	<?= Html::a('Add New Package', ['/package/add'], ['class'=>'btn btn-success']) ?>
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'type',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Type',
                ],
            ],
            [
                'attribute' => 'price',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Price',
                ],
            ],
            ['class' => 'yii\grid\ActionColumn' ,
			'template'=>'{update} ' ,
			 'header' => "Update",
			 'buttons' => [
				   'update' => function ($url, $model) {     
                                return Html::a(FA::icon('pencil lg'), $url, [
                                        'title' => Yii::t('yii', 'Update'),
                                ]);                                
            
                              },
					
			 ],
			],
			
			['class' => 'yii\grid\ActionColumn' ,
			'template'=>'{delete}' ,
			 'header' => "Delete",
			 'buttons' => [
				   
					'delete' => function ($url, $model) {     
                                return Html::a(FA::icon('trash lg'), $url, [
                                        'title' => Yii::t('yii', 'Delete'),
                                ]);                                
            
                              },
			 ],
			],
        ],
    ]); ?>

	