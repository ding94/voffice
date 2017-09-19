<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($upload, 'imageFile')->fileInput() ?>

<?= $form->field($model, 'title')->textInput() ?>

<?= $form->field($model, 'redirectUrl')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>