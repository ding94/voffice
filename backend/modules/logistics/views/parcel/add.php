<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

	$this->title = "Add Mail or Parcel";
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Received Mail'), 'url' => ['received-mail']];
	$this->params['breadcrumbs'][] = $this->title;
?>
	<?php $form = ActiveForm::begin(['action' =>['parcel/add-new-mail', 'id' => $id], 'method' => 'post',]);?>
		<?= $form->field($parcel, 'type')->dropDownList($list,['prompt' => ' -- Detail --']) ?>
		<?= $form->field($detail, 'sender')->textInput() ?>
		<?= $form->field($detail, 'signer')->textInput() ?>
		<?= $form->field($detail, 'address1')->textInput() ?>
		<?= $form->field($detail, 'address2')->textInput() ?>
		<?= $form->field($detail, 'address3')->textInput() ?>
		<?= $form->field($detail, 'postcode')->textInput() ?>
		<?= $form->field($detail, 'city')->textInput() ?>
		<?= $form->field($detail, 'state')->textInput() ?>
		<?= $form->field($detail, 'country')->textInput() ?>
		<?= $form->field($detail, 'weight')->textInput() ?>
		<div class="form-group">
	        <?= Html::submitButton( Yii::t('app', 'Add'), ['class' => 'btn btn-success']) ?>
	   </div>
	<?php ActiveForm::end();?>