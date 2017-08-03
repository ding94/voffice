<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

	$this->title = "Add Or Remove Permission";
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Role'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $id;
?>
	<h1><?= Html::encode($id)?></h1>

	<?php $form = ActiveForm::begin(['action' =>['auth/remove-role', 'id' => $id], 'method' => 'post',]);?>
    	<?= $form->field($model, 'child')->inline(true)->checkboxList($listAvailabe) ?>
    	<div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Remove Permission') ,['class' =>  'btn btn-danger']) ?>
	   </div>
	<?php ActiveForm::end();?>

	<?php $form = ActiveForm::begin(['action' =>['auth/add-role', 'id' => $id], 'method' => 'post',]);?>
    	<?= $form->field($model, 'child')->inline(true)->checkboxList($listAll) ?>
    	<div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Add Permission') ,['class' =>  'btn btn-warning']) ?>
	   </div>
	<?php ActiveForm::end();?>