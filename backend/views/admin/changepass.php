<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

	$this->title = "Change password";
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin();?>
    	<?= $form->field($model, 'password')->passwordInput() ?>
    	<?= $form->field($model, 'repass')->passwordInput() ?>
    	<div class="form-group">
	      	<?= Html::submitButton('Change Password', ['class' => 'btn btn-warning']) ?>
	   </div>
	<?php ActiveForm::end();?>
</div>