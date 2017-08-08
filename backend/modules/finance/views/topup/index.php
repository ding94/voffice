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
		  <?=Html::beginForm(['/finance/topup/direct'],'post');?>
		   <?=Html::submitButton('All', ['name'=>'action', 'value' => '0','class' => 'btn btn-info',]);?>
		  <?=Html::submitButton('Pending', ['name'=>'action', 'value' => '1','class' => 'btn btn-primary',]);?>
		   <?=Html::submitButton('Success', ['name'=>'action', 'value' => '3','class' => 'btn btn-success',]);?>
		  <?=Html::submitButton('Rejected', ['name'=>'action', 'value' => '4','class' => 'btn btn-danger',]);?>
		  <?=Html::submitButton('Problematic Payment', ['name'=>'action', 'value' => '2','class' => 'btn btn-warning',]);?>
		 
	
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

                    return Html::a('Picture',Yii::$app->urlManagerFrontEnd->baseUrl.'/'.$model->picture,['target'=>'_blank']); //open page in new tab
                
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
	
	<?= Html::endForm();?> 