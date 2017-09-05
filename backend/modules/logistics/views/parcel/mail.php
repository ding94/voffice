<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title = $searchModel->titlename;
    $this->params['breadcrumbs'][] = $this->title;
?>
    <?=Html::beginForm(['parcel/batch'],'post');?>
	 <?= Html::dropDownList('StatusChoice','',$list ,['prompt' => ' -- Select Status --']) ?>
    <?=Html::submitButton('Change Status', ['id'=>'chgStatus','class' => 'btn btn-info']);?>
   
    <?= GridView::widget([

        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
              [
                'class' => 'yii\grid\CheckboxColumn',
                // you may configure additional properties here
            ],
            [
                'attribute' => 'id',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search ID',
                ],
            ],
            [
                'attribute' => 'user.username',
                'label' => 'User Name',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Username',
                ],
            ],
            [
                'attribute' => 'user.userdetail.fullname',
                'label' => 'Full Name',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Full Name',
                ],
            ],
            [
                'attribute' => 'parceldetail.sender',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Sender',
                ],
            ],
            [
                'attribute' => 'parceldetail.signer',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Signer',
                ],
            ],
            [
                'attribute' => 'type',
                'value' => function($model)
                {
                    return $model->type == 1 ? 'Mail' : 'Parcel';
                },
                'filter' => array( "1"=>"Mail","2"=>"Parcel"),

            ],
            ['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{detail} {operate} ',
              'header' => "Message",
             'buttons' => [
                'detail' => function($url,$model)
                {
                    $url = Url::to(['parcel-detail/view','parid' => $model->id ,'status' => $model->status]);

                    return  Html::a('View' , $url , ['title' => 'View detail']) ;
                },
                'operate' => function($url , $model)
                {
                    $url = Url::to(['parcel-operate/view-operate' ,'parid'=>$model->id,'status' => $model->status]);
                    
                    return  Html::a('View Operate' , $url , ['title' => 'View Operate']) ;
                },
              ]
            ],
            ['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{next} ',
             'header' => "Action",
             'visible' => ($status != 3 && $status != 4),
             'buttons' => [
                'next' => function($url , $model)
                {
                    $url =  Url::to(['parcel/next-step' ,'id'=>$model->id,'status'=>$model->status]);

                    return  Html::a('Next Step' , $url , ['title' => 'Next Step']) ;
                },
              ]
            ],
        ],
    ]); ?>
    <?= Html::endForm();?> 

