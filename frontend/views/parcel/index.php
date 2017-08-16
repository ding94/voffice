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
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">...</h4>',
	'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
]);
$requestUrl = Url::toRoute('parcel/view');
Modal::end();
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");



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

				[
					'header' => 'View More',
					//'size' => 'modal-lg',
					'value' => function($model)
					{
						return Html::a(Yii::t('app','{modelClass}',['modelClass' => 'details']),['parcel/view' ,'parid'=>$model->id],['class'=>'btn btn-success','data-toggle'=>"modal",'data-target'=>"#myModal",'data-title'=>"Detail Data",]);


					},
					'format' => 'raw'
				],
				
            ], 
						 
        
		
		
    ]); 
		
	?>
	
</div>