<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

	//var_dump($model);exit;
	$this->title = 'New Voucher';
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Voucher List'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>


	<?php $form = ActiveForm::begin();?>
    <?= $form->field($discount ,'discount')->textInput()?>
    <?= $form->field($discount ,'discount_type')->dropDownList($type)?>
    <?= $form->field($discount ,'discount_item')->dropDownList($item)?>
    	<div class="form-group">
	        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Back', ['/vouchers/index'], ['class'=>'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
