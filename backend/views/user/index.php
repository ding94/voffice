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
            //['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'label' => 'Full Name',
                'attribute' => 'userdetail.fullname',
            ],
            'email',
            [
                'attribute' => 'status',
                'value' => function($model)
                {
                    return $model->status ==10 ? 'Active' : 'Inactive';
                }

            ],
          
			['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{active}',
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
                   
                    return  $model->status ==10  ? Html::a(FA::icon('toggle-on') , $url , ['title' => 'Deactive']) : Html::a(FA::icon('toggle-off') , $url , ['title' => 'Active']);
                },
              ]
            ],
			['class' => 'yii\grid\ActionColumn', 
             'template'=>'{view}{delete} ',],
        ],
    ]); ?>

