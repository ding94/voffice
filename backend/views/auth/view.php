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
	<div class="row">
		<div class="col-md-6">
			<div class="btn btn-primary btn-lg btn-block">Current Permission</div>
			<?php $form = ActiveForm::begin(['action' =>['auth/remove-role', 'id' => $id], 'method' => 'post',]);?>
				<?php foreach($listAvailabe as $i=>$value):?>
		    		<?= $form->field($model, 'child['.$i.']')->inline(true)->checkboxList($value)->label($controlList[$i]) ?>
		    	<?php endforeach;?>
		    	<div class="form-group">
			        <?= Html::submitButton(Yii::t('app', 'Remove Permission') ,['class' =>  'btn btn-danger']) ?>
			   </div>
			<?php ActiveForm::end();?>
		</div>
		<div class="col-md-6">
			<div class="btn btn-info btn-lg btn-block"> Other Permission</div>
			<?php $form = ActiveForm::begin(['action' =>['auth/add-role', 'id' => $id], 'method' => 'post',]);?>
		
				<?php foreach($listAll as $k=>$data):?>
				    <?= $form->field($model, 'child['.$k.']')->inline(true)->checkboxList($data)->label($controlList[$k]); ?>
				<?php endforeach;?>
			    <div class="form-group">
				    <?= Html::submitButton(Yii::t('app', 'Add Permission') ,['class' =>  'btn btn-warning']) ?>
				 </div>
			<?php ActiveForm::end();?>
		</div>
	</div>
	


	