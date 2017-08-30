<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;
use yii\bootstrap\Modal;
use common\models\Package;
use kartik\widgets\ActiveForm;

$type = ArrayHelper::map(Package::find()->all(),'id','type');

?>

<div class="container" style="padding-top: 200px">
<div class="row">
<div class="col-md-7 col-md-offset-1">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin([
		'options'=>[
			'id'=>'form',
		],
	]);?>
		<?= $form->field($payment, 'package_type')->dropDownList($type,[
			'id'=>'package',
		]); ?>
		<?= $form->field($payment, 'amount',['template' => '
       		<div class="input-group">
          		<span class="input-group-addon">
             		RM
          		</span>
          		{input}
       		</div>
       {error}{hint}'])->textInput([
       		'readonly' => true,
			'options'=>[
				'id'=>'amount',
			],
		]) ?>

    	<div class="form-group">
	        <?= Html::submitButton('Subscribe', [
	        	'class' => 'btn btn-primary',
	        	'onClick' => 'return confirm("Confirm Subscription?")',
	        ]) ?>
	   </div>
	<?php ActiveForm::end();?>
</div>
</div>
</div>