<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use iutbay\yii2fontawesome\FontAwesome as FA;

	$this->title = 'Offline Topup';
	$this->params['breadcrumbs'][] = $this->title;
	
?>

	
	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
			 ['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{update} {cancel} {img}',
             'buttons' => [
                'update' => function($url , $model)
                    {
                       $url = Url::to(['topup/update','id'=>$model->id,'admin'=>Yii::$app->user->identity->id]);//创建链接，带着uid值
                        return   Html::a(FA::icon('check fw') ,$url , ['title' ,'update']);//图案，链接，不知知道干嘛的
                    },
					
				'cancel' => function($url , $model)
                    {
                       $url = Url::to(['topup/cancel','id'=>$model->id,'admin'=>Yii::$app->user->identity->id]);//创建链接，带着uid值
                        return   Html::a(FA::icon('ban fw') ,$url , ['title' ,'cancel']);//图案，链接，不知知道干嘛的
                    },
					
				'img' => function($url,$model)
                {

                    return Html::a('Picture',Yii::$app->urlManagerFrontEnd->baseUrl.'/'.$model->picture,['target'=>'_blank']);
                
                },
              ],
			 ],
        
    	            'username',
    	            'amount',
    	            'description',
    	            'action',
    	            'inCharge',
    	            'rejectReason',
    	            //'picture',
					
        ],
		
		
    ])?>