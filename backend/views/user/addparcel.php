<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

	//var_dump($model);exit;
	$this->title = $user->Fname.' ' .$user->Lname;
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User'), 'url' => ['user-parcel']];
	$this->params['breadcrumbs'][] = $this->title;
?>


	<?php $form = ActiveForm::begin();?>
    	<?= $form->field($model, 'arrived_time')->widget(DatePicker::classname(), [
    		'options' => ['placeholder' => 'Date parcel arrived in warehouse'],
    		'pluginOptions' => [
    			//'language' => 'ru',
    			'format' => 'yyyy-mm-dd',
	    		'todayHighlight' => true,
	        	'todayBtn' => true,]]) 
	    ?>
	    <?= $form->field($parcel, 'sender')->textInput() ?>
    	<?= $form->field($parcel, 'address1')->textInput() ?>
    	<?= $form->field($parcel, 'address2')->textInput() ?>
    	<?= $form->field($parcel, 'address3')->textInput() ?>
        <?= $form->field($parcel, 'postcode', array(
                    'ajax'=> array(
                    'type'=>'GET', 
                    'data'=>'js:{postcode:$(this).val()}',
                    'url'=>CController::createUrl('customer/xgetName),
                    'success'=>'js:function(data) {
                       $("#'.CHtml::activeId($model,'name').'").val(data);
                    }'
                  )
          ))->textInput() ?>
    	<?= $form->field($parcel, 'city')->textInput() ?>
    	<?= $form->field($parcel, 'state')->textInput() ?>
    	<?= $form->field($parcel, 'country')->textInput() ?>
    	<?= $form->field($parcel, 'weight')->textInput() ?>
    	
    	<div class="form-group">
	        <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
            
	   </div>
	<?php ActiveForm::end();?>
