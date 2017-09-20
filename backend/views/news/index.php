<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?= GridView::widget([
        'dataProvider' => $model,
        'columns' => [
	
			// ['class' => 'yii\grid\ActionColumn' , 
   //           'template'=>' {img}',
   //           'buttons' => [
			// 	'img' => function($url,$model)
	  //               {
	  //                   return Html::a('Picture',Yii::$app->urlManagerFrontEnd->baseUrl.'/'.$model->name,['target'=>'_blank']); //open page in new tab
	  //               },
   //            	],
			// ],
			
			[
            	'attribute' => 'id',
            ],
            [
                'attribute' => 'name',
            ],

            [
                'attribute' => 'text',
                'contentOptions' => ['style'=>'max-width: 300px; overflow: auto; word-wrap: break-word;'],
            ],

            [
                'attribute' => 'startTime',
            ],

            [
                'attribute' => 'endTime',
            ],

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{delete}',
        	]
					
        ],
		
		
    ])?>