
<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
	
?>
<html>

 <div class="row">
         <div class="col-lg-12 text-center" id="topup">
      
<br><br>	
			<h1>Offline Topup</h1>
			
            <?php $form = ActiveForm::begin(['action' =>['topup/upload'], 'method' => 'post',]); ?>

				 <?= $form->field($model, 'amount') ?>

                <?= $form->field($model, 'description') ?>
								
                <?= $form->field($model, 'picture')->fileInput() ?>
                       <div class="form-group">
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
   
			</div>					

</html>