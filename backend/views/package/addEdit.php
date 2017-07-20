<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

	$this->title = $model->packageTitle;
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Package'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin();?>
    	<?= $form->field($model, 'type')->textInput() ?>	
    	<?= $form->field($model, 'price')->textInput() ?>
    	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
</div>