
<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
	
	
?>

<div class="container">
 <div class="row">
         <div class="col-lg-6 col-lg-offset-1 text-center" id="topup">
		
     
			<h1>Offline Topup</h1>
			
            <?php $form = ActiveForm::begin(); ?>

				 <?= $form->field($model, 'amount') ?>

                <?= $form->field($model, 'description') ?>
								
                <?= $form->field($upload, 'imageFile')->fileInput() ?>
                       <div class="form-group">
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
   
			</div>					
</div>