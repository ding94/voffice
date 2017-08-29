
<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
	use yii\grid\GridView;
use yii\grid\ActionColumn;
	
?>

<div class="container">
 <div class="row">
         <div class="col-md-7 col-md-offset-1 text-center" id="topup">
		
     
			<h1>Offline Topup</h1>
			
            <?php $form = ActiveForm::begin(); ?>

				 <?= $form->field($model, 'amount') ?>

                <?= $form->field($model, 'description') ?>
				
				<?= $form->field($model, 'bank_name')->dropDownList($items)?>
								
                <?= $form->field($upload, 'imageFile')->fileInput() ?>
                       <div class="form-group">
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
   
			</div>					
</div>