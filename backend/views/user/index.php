<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title =  'User List';
    $this->params['breadcrumbs'][] = $this->title;
?>

    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
                'attribute' => 'status',
                'value' => function($model)
                {
                    return $model->status ==10 ? 'Active' : 'Inactive';
                }

            ],
         
			 ['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{view} ',
             'header' => "View",
			  'buttons' => [
				   'view' => function ($url, $model) {     
                                return Html::a(FA::icon('eye lg'), $url, [
                                        'title' => Yii::t('yii', 'View'),
                                ]);                                
            
                              }
			 ],
             
            ],
			 
			 
			['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{active} ',
			 'header' => "Action",
             'buttons' => [
                'active' => function($url , $model)
                {
                    if($model->status == 0)
                    {
                         $url = Url::to(['user/active' ,'id'=>$model->id]);
                    }
                    else
                    {
                        $url = Url::to(['user/delete' ,'id'=>$model->id]) ;
                    }
                   
                    return  $model->status ==10  ? Html::a(FA::icon('toggle-on lg') , $url , ['title' => 'Deactivate']) : Html::a(FA::icon('toggle-off lg') , $url , ['title' => 'Activate']);
                },
              ]
            ],
        ],
    ]); ?>

