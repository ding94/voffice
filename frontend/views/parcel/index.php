<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\models\Parcel\ParcelStatusName;
use iutbay\yii2fontawesome\FontAwesome as FA;


?>
<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'=>$searchModel,
        'columns' => [
           
                'parceldetail.sender',
                'parceldetail.city',
                'parceldetail.state',
                'parceldetail.country',
               // 'parceldetail.weight',
                [
                    'attribute' => 'status',
                    'value' => 'parcelstatusname.description',
                    'filter'=>Html::activeDropDownList($searchModel,'status',ArrayHelper::map(ParcelStatusName::find()->asArray()->all(), 'id', 'description'),['class'=>'form-control','prompt' => '--Select Status--']),
                    //'filter'=>ArrayHelper::map(ParcelStatusName::find()->asArray()->all(), 'id', 'description'),
                ],
				['class' => 'yii\grid\ActionColumn' , 
             'template'=>'{view}',
              'header' => 'Message',
             'buttons' => [
                'detail' => function($url,$model)
                {
                    $url = Url::to(['parcel/view' ,'parid'=>$model->id]);

                    return  Html::a(FA::icon('eye fw'), $url , ['title' => 'View detail']) ;
					
                },
                
              ]
            ],
				 
        ],
		
		
    ]); ?>
</div>