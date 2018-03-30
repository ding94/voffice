<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
?>
<?php 
Modal::begin([
'id' => 'reason-modal',
'header' => '<h4 class="modal-title">Reject Reason</h4>',
'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
]); 
$requestUrl = Url::toRoute('user/rejectreason');
$js = <<<JS
$.get('{$requestUrl}', {},
function (data) {
$('.modal-body').html(data);
} 
);
JS;
$this->registerJs($js);
Modal::end(); 
?>

<div class="balance">
    <div id="userprofile" class="row">
       <div class="userprofile-header">
            <div class="userprofile-header-title">Account Balance</div>
        </div>
        <div class="topup-detail">
            <div class="col-sm-2" style="padding-bottom:20px;">
                <div class="nav-url">
                  <ul class="nav nav-pills nav-stacked">
                      <li role="presentation" class="active"><a href="#" class="btn-block userprofile-edit-left-nav">Account Balance</a></li>
                      <li role="presentation"><?php echo Html::a('Account History',['topup-history/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation"><?php echo Html::a('Top Up',['topup/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation"><?php echo Html::a('Withdraw',['withdraw/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                  </ul>
                </div>
            </div>
            <div class="col-sm-10 right-side">
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">My Balance: </div>
                  <div class="userprofile-text">RM<?php echo $model['balance']; ?></div>
                </div>
              </div>
              <?php 
              if ($offlinetopup['rejectReason']!= null) { 
               echo Html::a('Reject Reason', '#', ['id' => 'rejectreason','data-toggle' => 'modal','data-target' => '#reason-modal','class' => 'btn btn-success',]);
              }
              ?>
            </div>
        </div>
    </div>
</div>