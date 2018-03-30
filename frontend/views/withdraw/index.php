<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
/* @var $this yii\web\View */

?>

<div class="balance">
    <div id="userprofile" class="row">
       <div class="userprofile-header">
            <div class="userprofile-header-title">Withdraw</div>
        </div>
        <div class="topup-detail">
            <div class="col-sm-2" style="padding-bottom:20px;">
                <div class="nav-url">
                  <ul class="nav nav-pills nav-stacked">
                      <li role="presentation"><?php echo Html::a('Account Balance',['user/userbalance'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation"><?php echo Html::a('Account History',['topup-history/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation"><?php echo Html::a('Top Up',['topup/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation" class="active"><a href="#" class="btn-block userprofile-edit-left-nav">Withdraw</a></li>
                  </ul>
                </div>
            </div>
            <div class="col-sm-10 right-side">
            	<br>
            	<i><p>My Balance: <?php echo $balance['balance']; ?></i></p>
				<i><p>You can withdraw below RM<?php echo $balance['balance']-2; ?>. Transfer fee RM2.</i></p>
				<br>
            	<?php $form = ActiveForm::begin(); ?>

	            	<?= $form->field($model, 'withdraw_amount')->textInput() ?>
	            	<?= $form->field($model, 'bank_name')->dropDownList($name)?>
	            	<?= $form->field($model, 'to_bank')->textInput() ?>		
	            	<?= $form->field($model, 'acc_name')->textInput() ?>				   

	            	<div class="form-group">
	            		<?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
	            	</div>

            	<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>