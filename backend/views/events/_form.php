<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Events */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="events-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'start')->widget(DateTimePicker::classname(),[
								    'pluginOptions' => [
								        'autoclose'=>true,
								        'format' => 'yy-mm-dd hh:ii'
								    ],
								    ]) ?>

    <?= $form->field($model, 'end')->widget(DateTimePicker::classname(),[
								    'pluginOptions' => [
								        'autoclose'=>true,
								        'format' => 'yy-mm-dd hh:ii'
								    ],
								    ]) ?>

	<?= $form->field($model, 'details')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
