<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;

use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title =  'Add Voucher';
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Voucher'), 'url' => ['/user/uservoucherlist']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin();?>
    <?= $form->field($uservoucher, 'code')->textInput() ?>
  
    	<?= $form->field($uservoucher, 'limitedTime')->widget(DatePicker::classname(), [
    		'options' => ['placeholder' => 'Date voucher deactived'],
    		'pluginOptions' => [
    		'format' => 'yyyy-mm-dd',
	    	'todayHighlight' => true,
	        'todayBtn' => true,]]) 
	    ?>

        <?= $form->field($voucher, 'discount')->textInput()->input('',['placeholder' => 'Not required when existing code used']) ?>
        <?= $form->field($voucher ,'status')->dropDownList($list)?>

    	<div class="form-group">
	        <?= Html::submitButton('Add', [
                'class' => 'btn btn-danger', 
                'data' => [
                    'confirm' => 'If code alr exist, it will replace by its own discounts, continue?',
                    'method' => 'post',
            ]]);?>
            
            <?= Html::a('Back', ['/user/uservoucherlist'], ['class'=>'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>

	</br>

	<H3>Usable Vouchers </H3>

	 <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'code',
            'discount',
            
        ],
    ]); ?>