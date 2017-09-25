<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\DateTimePicker;
use dosamigos\ckeditor\CKEditor;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full'
    ]) ?>

<?= $form->field($model, 'startTime')->widget(DateTimePicker::classname(), [
		    'options' => ['placeholder' => 'Enter start date and time ...'],
		    'pluginOptions' => [
		    	'format' => 'yyyy-mm-dd hh:ii:ss',
		        'autoclose'=>true,
		        'startDate' => date('Y-m-d h:i:s'),
		    ]
		]) ?>
<?= $form->field($model, 'endTime')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Enter end date and time ...'],
    'pluginOptions' => [
    	'format' => 'yyyy-mm-dd hh:ii:ss',
        'autoclose'=>true,
        'startDate' => date('Y-m-d h:i:s'), 
    ]
]) ?>
    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>