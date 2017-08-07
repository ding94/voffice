<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

	//var_dump($model);exit;
	$this->title = 'Offline Topup';
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Offline Topup'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>


	<?php $form = ActiveForm::begin();?>
	
	
	
    <?= $form->field($model, 'username')->textInput(['readonly' => true]) ?>
	<?= $form->field($model, 'amount')->textInput(['readonly' => true]) ?>
	<?= $form->field($model, 'description')->textInput(['readonly' => true]) ?>
	<?= $form->field($model, 'rejectReason')->textInput() ?>
	
	    	
    	<div class="form-group">
	        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
			 <?= Html::a('Back', ['/finance/topup/index'], ['class'=>'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>