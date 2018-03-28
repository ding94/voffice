<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use common\widgets\Alert;
use kartik\widgets\Select2;
use bootstrap\widgets\CActiveForm;
/* @var $this yii\web\View */
?>

<?= Alert::widget() ?>
<div class="profile">
	<div id="userprofile" class="row">
	   <div class="userprofile-header">
	        <div class="userprofile-header-title"><?php echo Html::encode($this->title)?></div>
	    </div>
	    <div class="userprofile-detail">
	        <div class="col-sm-2">
	            <div class="nav-url">
	                <ul class="nav nav-pills nav-stacked">
	                    <li role="presentation" ><?php echo Html::a('Edit User Profile',['user/useredit'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
	                    <li role="presentation" class="active"><a href="#" class="btn-block userprofile-edit-left-nav">Change Password</a></li>
	                </ul>
	            </div>
	        </div>
	    </div>
	    <div class="container">
	        <div class="col-sm-8 userprofile-edit-input">
	            <?php $form = ActiveForm::begin();?>
					<?= $form->field($model, 'old_password')->passwordInput() ?>
					<?= $form->field($model, 'new_password')->passwordInput() ?>
					<?= $form->field($model, 'repeat_password')->passwordInput() ?>
			    	<div class="form-group">
				        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
				   </div>
				<?php ActiveForm::end();?>
	        </div>
	    </div>
	</div>
</div>