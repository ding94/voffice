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
$period = array(1 => 'Monthly',12 => 'Annual');
$fprice = $type['1'];
switch ($fprice) {
	case 1:
		$fprice = 100;
		break;
	
	default:
		$fprice = 100;
		break;
}
?>
<div class="container page-wrap">
	<div class="row">
		<div class="col-md-7 col-md-offset-1">
			<h1><?= Html::encode($this->title) ?></h1>
			<?php $form = ActiveForm::begin([
				'options'=>[
					'id'=>'form',
				],
				'action' => [
					'subscribe/make-subscribe',
				]
			]);?>

			<?= $form->field($subscribe, 'packid')->dropDownList($type,[
				'id'=>'package',
				'prompt'=>'Please choose package',
			]); ?>

			<label>Package Price/per month</label>

			<?= $form->field($payment, 'paid_amount',['template' => '
		       	<div class="input-group" id="amount">
		        <span class="input-group-addon">RM</span>{input}
		       	</div>{error}{hint}',
		       	])->textInput([
		       		'readonly' => true,
		       		//'value' =>$fprice,
					'options'=>[
						'id'=>'paid_amount',
					],
				]) ?>

		       <?= $form->field($subscribe,'sub_period')->dropDownList($items,[
					'id'=>'package',
					'onchange' => 'js:changeperiod();',
				]) ?>

				<div class="form-group">
			        <?= Html::submitButton('Proceed Next Step', [
			        	'class' => 'btn btn-primary',
			        	'id' =>'subscribe',
			        	//'onClick' => 'return confirm("Confirm Subscription?")',
			        ]) ?>
			   	</div>
				<?php ActiveForm::end();?>

			</div>
		</div>
	</div>
</div>