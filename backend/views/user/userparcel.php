<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;

	$this->title = 'Arrange Parcel';
	$this->params['breadcrumbs'][] = $this->title;
    
    //$url = Url::to(['user/add','id'=>8]);

?>

	
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [

    	            [  
                        'attribute' => 'cmpyName',
                        'value' => 'company.cmpyName',//你选择的table的column
                    ],
                    
                    [   

                        'attribute' => 'Fname',
                        'value' => function($model) { return $model->Fname  . " " . $model->Lname ;}, //function($model) <- pass model进去
                    ],

               ['class' => 'yii\grid\ActionColumn',  
                'template'=>'{add}', //送去actionAdd
                'buttons' => [
                'add' => function($url , $model)
                    {
                       $url = Url::to(['user/add','id'=>$model->uid,'admin'=>Yii::$app->user->identity->id]);//创建链接，带着uid值
                        return   Html::a(FA::icon('plus 2x fw') ,$url , ['title' ,'add']);//图案，链接，不知知道干嘛的
                    },
                 ] 
             ],
        ]
    ])?>

 