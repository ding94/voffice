<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use common\widgets\Alert;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
?>

<?= Alert::widget() ?>
<div class="row">
<div class="col-lg-7 col-lg-offset-1 " >
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin();?>
		<?= $form->field($model, 'address1')->textInput() ?>
		<?= $form->field($model, 'address2')->textInput() ?>
		<?= $form->field($model, 'address3')->textInput() ?>
    	<?= $form->field($model, 'postcode')->textInput() ?>
    	<?= $form->field($model, 'state')->textInput() ?>
    	<?= $form->field($model, 'city')->textInput() ?>
    	<?= $form->field($model, 'country')->textInput() ?>
    	<?= $form->field($model, 'phonenumber')->textInput() ?>
    	<div class="form-group">
	        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
</div>
</div>
