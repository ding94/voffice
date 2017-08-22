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
<div class="container">
<div class="row">
<div class="col-md-7 col-md-offset-1 " >
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin();?>
		<?= $form->field($model, 'cmpyName')->textInput() ?>
		<?= $form->field($model, 'cmpyRegisNo')->textInput() ?>
		<?= $form->field($model, 'cmpyType')->textInput() ?>
    	<?= $form->field($model, 'industry')->textInput() ?>
    	<div class="form-group">
	        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
</div>
</div>
</div>