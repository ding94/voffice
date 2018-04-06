<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\LinkPager;
use frontend\assets\ParcelAsset ;
use common\models\Parcel\ParcelStatusName;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;


ParcelAsset::register($this);
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

$this->title = 'My Parcel'." : ".$title;
?>

<div class="parcel">
    <div id="userprofile" class="row">
        <div class="userprofile-header">
            <div class="userprofile-header-title"><?php echo HTML::encode($this->title) ?></div>
        </div>
        <div class="parcel-detail">
            <div class="col-sm-2" style="padding-bottom:20px;">
                <div class="dropdown-url">
                    <?php echo Select2::widget([
                      'name' => 'url-redirect',
                      'hideSearch' => true,
                      'data' => $link,
                      'options' => [
                          'placeholder' => 'Go To ...',
                          'multiple' => false,  
                        ],
                      'pluginEvents' => [
                            "change" => 'function (e){
                              location.href =this.value;
                          }',
                      ]
                    ]);?>
                </div>
                <div class="nav-url">
                  <ul id="my-parcel-nav"class="nav nav-pills nav-stacked">
                       <li role="presentation" ><?php echo Html::a('All',['/parcel/index'],['class'=>' btn-block userprofile-edit-left-nav'])?></li>
                      <?php foreach($countParcel as $i=> $count): ?>
                          <li><?php echo Html::a($i.'<span class="badge">'.$count['total'].'</span>',['/parcel/index','status'=>$statusid[$i]],['class'=>' btn-block userprofile-edit-left-nav'])?></li>
                      <?php endforeach ;?>
                  </ul>
                </div>
            </div>
            <div class="col-sm-10 right-side ">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions'=>['class'=>'table table-striped table-bordered my-parcel-table'],
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
                            return Html::a(Yii::t('app','{modelClass}',['modelClass' => 'details']),['parcel/view' ,'parid'=>$model->id],['class'=>'btn btn-success ','data-toggle'=>"modal",'data-target'=>"#myModal",'data-title'=>"Detail Data",]);
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

                                return $model->status == 3 ? Html::a('Confirm Received' , $url , ['class' => 'btn btn-primary','title' => 'Confirm Received','data-confirm'=>"Confirm action?"]): '' ;
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