<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

	$this->title = "Parcel ID ".$model->parid. " update";
    $this->params['breadcrumbs'][] = ['label' => 'Mail Index', 'url' => ['parcel/type-mail','status'=>$status]];
	$this->params['breadcrumbs'][] = ['label' => 'Parcel ID '.$model->parid.' detail', 'url' => ['parcel-detail/view' ,'parid' => $model->parid, 'status' => $status]];
	$this->params['breadcrumbs'][] = $this->title;
?>

	<?php $form = ActiveForm::begin();?>
    	<?= $form->field($model, 'sender')->textInput() ?>
        <?= $form->field($model, 'signer')->textInput() ?>
        <?= $form->field($model, 'address1')->textInput() ?>
        <?= $form->field($model, 'address2')->textInput() ?>
        <?= $form->field($model, 'address3')->textInput() ?>
        <?= $form->field($model, 'postcode')->textInput() ?>
        <?= $form->field($model, 'city')->textInput() ?>
        <?= $form->field($model, 'state')->textInput() ?>
        <?= $form->field($model, 'country')->textInput() ?>
    	<?= $form->field($model, 'weight')->textInput() ?>
    		
    	<div class="form-group">
	        <?= Html::submitButton( Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>