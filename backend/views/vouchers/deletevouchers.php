<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

	//var_dump($model);exit;
	$this->title = 'Delete Voucher';
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Voucher List'), 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
?>


	<?php $form = ActiveForm::begin();?>
    <?= GridView::widget([ 
        'dataProvider' => $model,
        'filterModel' => $searchModel,

        foreach ($model as $model): 
        

        endforeach 
    
         ])?>
    

    	
    	<div class="form-group">
	        <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
	   </div>
	<?php ActiveForm::end();?>
