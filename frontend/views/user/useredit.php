<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use common\widgets\Alert;
use kartik\widgets\Select2;
use common\models\Country;
use yii\helpers\ArrayHelper;

$country = Country::find()->all();
$data = ArrayHelper::map($country,'name_en','name_en');

/* @var $this yii\web\View */
?>


<div class="row">
<div class="col-md-7 col-md-offset-1 " >
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin();?>
		<?= $form->field($model, 'Fname')->textInput() ?>
		<?= $form->field($model, 'Lname')->textInput() ?>
		<?= $form->field($model, 'gender')->radioList(array('Male'=>'Male','Female'=>'Female')); ?>
		<?= $form->field($model, 'DOB')->widget(DatePicker::classname(), [
		    'options' => ['placeholder' => 'Enter birth date ...'],
		    'pluginOptions' => [
		    	'todayHighlight' => true,
        		'todayBtn' => true,
		    	'format' => 'yyyy-mm-dd',
		        'autoclose'=>true,
		        'endDate'=>date('Y/m/d',strtotime('-1 day'))
		    ]
		]) ?>
		<?= $form->field($model, 'IC_passport')->textInput() ?>
    	<?= $form->field($model, 'address1')->textInput() ?>
    	<?= $form->field($model, 'address2')->textInput() ?>
    	<?= $form->field($model, 'address3')->textInput() ?>
    	<?= $form->field($model, 'postcode')->textInput() ?>
    	<?= $form->field($model, 'state')->textInput() ?>
    	<?= $form->field($model, 'city')->textInput() ?>
    	<?= $form->field($model, 'country')->dropDownList($data) ?>
    	<?= $form->field($model, 'phonenumber')->textInput() ?>
    	<div class="form-group">
	        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
</div>
</div>