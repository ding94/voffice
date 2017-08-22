<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;

use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use iutbay\yii2fontawesome\FontAwesome as FA;

    $this->title =  'Add Voucher';
    $this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin();?>
    <?= $form->field($uservoucher, 'code')->textInput() ?>
  
    	<?= $form->field($uservoucher, 'limitedTime')->widget(DatePicker::classname(), [
    		'options' => ['placeholder' => 'Date voucher active to use'],
    		'pluginOptions' => [
    			//'language' => 'ru',
    		'format' => 'yyyy-mm-dd',
	    	'todayHighlight' => true,
	        'todayBtn' => true,]]) 
	    ?>

    	<div class="form-group">
	        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Back', ['/vouchers/index'], ['class'=>'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
	</br>
	<H3>Usable Vouchers </H3>
	 <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'code',
            
        ],
    ]); ?>