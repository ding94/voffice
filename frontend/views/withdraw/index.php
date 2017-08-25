<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
/* @var $this yii\web\View */
?>

<div class="container">
	<div class="tab-content col-md-7 col-md-offset-1" id="withdraw">
	<h1>User Withdraw</h1>
              <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'acc_name')->textInput() ?>
				 <?= $form->field($model, 'withdraw_amount')->textInput() ?>
				   <?= $form->field($model, 'to_bank')->textInput() ?>				
				<?= $form->field($model, 'bank_name')->dropDownList($items)?>
                <div class="form-group">
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            
	</div>
</div>