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
            'id',
            [
                'attribute' => 'user.username',
                'label' => 'User Name',
            ],
            [
                'attribute' => 'user.userdetail.fullname',
                'label' => 'Full Name',
            ],

            'parceldetail.sender',
            'parceldetail.signer',
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

                    return  Html::a(FA::icon('info-circle lg') , $url , ['title' => 'View detail']) ;
                },
                'operate' => function($url , $model)
                {
                    $url = Url::to(['parcel-operate/view-operate' ,'parid'=>$model->id,'status' => $model->status]);
                    
                    return  Html::a(FA::icon('eye lg') , $url , ['title' => 'View Operate']) ;
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

                    return  Html::a(FA::icon('check lg') , $url , ['title' => 'Next Step']) ;
                },
              ]
            ],
        ],
    ]); ?>
    <?= Html::endForm();?> 

