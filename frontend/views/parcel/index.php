<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\models\Parcel\ParcelStatusName;
use iutbay\yii2fontawesome\FontAwesome as FA;
use yii\bootstrap\Modal;


?>
<?php
Modal::begin(['id' => 'modal',
'header' => '<h4 class="modal-title">More Details</h4>',
'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
]);
$requestUrl = Url::toRoute('parcel/view');
Modal::end();

$this->registerJs("$(function() {
   $('#popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body')
     .load($(this).attr('href'));
   });
});");
?>
	<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	
		<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'=>$searchModel,
        'columns' => [
           
                'parceldetail.sender',
                //'parceldetail.signer',
               // 'parceldetail.address1',
               // 'parceldetail.address2',
               // 'parceldetail.address3',
               // 'parceldetail.postcode',
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
				[
					'header' => 'View More',
					//'size' => 'modal-lg',
					'value' => function($model)
					{
						return Html::a(Yii::t('app','{modelClass}',['modelClass' => 'details']),['parcel/view' ,'parid'=>$model->id],['class'=>'btn btn-success','id' => 'popupModal']);
					},
					'format' => 'raw'
				],
				
            ], 
						 
        
		
		
    ]); 
		
	?>
	
</div>