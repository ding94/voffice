<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use common\widgets\Alert;
/* @var $this yii\web\View */
?>

<?= Alert::widget() ?>
<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin();?>
		<?= $form->field($model, 'Fname')->textInput() ?>
		<?= $form->field($model, 'Lname')->textInput() ?>
		<?= $form->field($model, 'gender')->dropdownList([
		        'Male' => 'Male', 
		        'Female' => 'Female'
		    ],
		    ['prompt'=>'Select Gender']
		)?>
		<?= $form->field($model, 'DOB')->widget(DatePicker::classname(), [
		    'options' => ['placeholder' => 'Enter birth date ...'],
		    'pluginOptions' => [
		    	'todayHighlight' => true,
        		'todayBtn' => true,
		    	'format' => 'yyyy-mm-dd',
		        'autoclose'=>true
		    ]
		]) ?>
		<?= $form->field($model, 'IC_passport')->textInput() ?>
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