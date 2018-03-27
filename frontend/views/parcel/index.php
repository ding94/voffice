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

<div class="parcel">
    <div id="userprofile" class="row">
       <div class="userprofile-header">
            <div class="userprofile-header-title">Parcel</div>
        </div>
        <div class="parcel-detail">
            <div class="col-sm-2" style="padding-bottom:20px;">
                <div class="nav-url">
                  <ul class="nav nav-pills nav-stacked">
                      <li role="presentation" class="active"><a href="#" class="btn-block userprofile-edit-left-nav">My Parcel</a></li>
                  </ul>
                </div>
            </div>
            <div class="col-sm-10 right-side">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel'=>$searchModel,
                    'columns' => [
                        [
                            'attribute' => 'parceldetail.sender',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Search Sender',
                            ],
                        ],
             /*   [
                    'attribute' => 'parceldetail.city',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search City',
                         ],
                ],
                [
                    'attribute' => 'parceldetail.state',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search State',
                         ],
                ],
                [
                    'attribute' => 'parceldetail.country',
                    'filterInputOptions' => [
                            'class'       => 'form-control',
                            'placeholder' => 'Search Country',
                         ],
                     ],*/
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
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{earlypostal}',
                        'header' => "Early Postal Option",
                        'buttons' => [
                            'earlypostal' => function($url , $model)
                            {
                                $url =  Url::to(['parcel/earlypostal' ,'id'=>$model->id,'status'=>$model->status]);

                                return $model->status == 2 ? Html::a('Early Postal' , $url , ['class' => 'text-underline','title' => 'Early Postal','data-confirm'=>"Confirm action?"]): '' ;
                            },
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{confirmreceived}',
                        'header' => "Confirm Received",
                        'buttons' => [
                            'confirmreceived' => function($url , $model)
                            {
                                $url =  Url::to(['parcel/confirmreceived' ,'id'=>$model->id,'status'=>$model->status]);

                                return $model->status == 3 ? Html::a('Confirm Received' , $url , ['class' => 'text-underline','title' => 'Confirm Received','data-confirm'=>"Confirm action?"]): '' ;
                            },
                        ],
                    ],
                ], 
            ]); 
            ?>
            </div>
        </div>
    </div>
</div>