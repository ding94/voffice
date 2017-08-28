<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\models\Parcel\ParcelStatusName;
use iutbay\yii2fontawesome\FontAwesome as FA;
use yii\bootstrap\Modal;
use common\models\Package;
use kartik\widgets\ActiveForm;
use kartik\widgets\DepDrop;

$type = ArrayHelper::map(Package::find()->all(),'id','type');

?>

<div class="container" style="padding-top: 200px">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin([
		'options'=>[
			'id'=>'form',
		],
	]);?>
		<?= $form->field($payment, 'package_type')->radioList($type,['name'=>'test']); ?>
		<?= $form->field($payment, 'amount')->textInput([
			'options'=>[
				'id'=>'amount',
			],
		]) ?>

		<?= $form->field($payment, 'package_type')->dropDownList($type,['id'=>'test']); ?>
		<?= $form->field($payment, 'amount')->widget(DepDrop::classname(), [
    		'options'=>['id'=>'amount'],
    		'pluginOptions'=>[
        		'depends'=>['test'],
        		'url'=>Url::to(['payment/amount'])
    			]
		]); ?>

		<?= $form->field($payment, 'package_type')->dropDownList($type,[
			'id'=>'test',
			'onchange'=>'$.post("'.Yii::$app->urlManager->createUrl(['payment/amount','id' => '']).'",function(data){$("input:text").val(data);});'
		]); ?>
		<?= $form->field($payment, 'amount')->textInput([
			'options'=>[
				'id'=>'amount',
			],
		]) ?>

    	<div class="form-group">
	        <?= Html::submitButton('Buy', ['class' => 'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
</div>