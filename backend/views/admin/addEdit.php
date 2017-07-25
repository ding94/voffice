<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

	$this->title = $model->adminTittle;;
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin();?>
    	<?= $form->field($model, 'adminname')->textInput() ?>
    	<?= $form->field($model, 'email')->textInput() ?>
    	<?php if(is_null($model->passwordOff)):?>
    		<?= $form->field($model, 'password')->passwordInput() ?>
    	<?php endif ;?>
    	<?= $form->field($model , 'status')->dropDownList(['10' => 'Active' , '0' => 'Inactive']) ?>
    	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
</div>