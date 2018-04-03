<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

	//var_dump($model);exit;
	$this->title = $title;
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Voucher List'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>


	<?php $form = ActiveForm::begin();?>
    <?= $form->field($model, 'code')->textInput() ?>
    <?= $form->field($discount, 'discount')->textInput() ?>
    <?= $form->field($discount ,'discount_type')->dropDownList($list)?>
    <?= $form->field($discount ,'discount_item')->dropDownList($item)?>
    <?php if($title == 'New Special Voucher'): ?>
        <?= $form->field($condition ,'condition_id')->dropDownList($con, ['prompt'=>'Unlimited Use'])->label('Special Condition')?>
        <?= $form->field($condition ,'amount')->textInput()?>
    <?php endif; ?>
    	<?= $form->field($model, 'startDate')->widget(DatePicker::classname(), [
    		'options' => ['placeholder' => 'Date voucher active to use'],
    		'pluginOptions' => [
    		'format' => 'yyyy-mm-dd',
            'startDate' => date('Y-m-d'), 
	    	'todayHighlight' => true,
	        'todayBtn' => true,]]) 
	    ?>

        <?= $form->field($model, 'endDate' )->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Date voucher deactivated'],
            'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'startDate' => date('Y-m-d h:i:s'), 
            'todayHighlight' => true,
            'todayBtn' => true,]]) 
        ?>

    	
    	<div class="form-group">
	        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
            <?php if($title == 'New Special Voucher'): ?>
                <?= Html::a('Back', ['/vouchers/special-voucher'], ['class'=>'btn btn-primary']) ?>
            <?php else: ?>
                <?= Html::a('Back', ['/vouchers/index'], ['class'=>'btn btn-primary']) ?>
            <?php endif; ?>
            
	   </div>
	<?php ActiveForm::end();?>
