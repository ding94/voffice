<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

?>

<div class="balance">
    <div id="userprofile" class="row">
       <div class="userprofile-header">
            <div class="userprofile-header-title">Top Up</div>
        </div>
        <div class="topup-detail">
            <div class="col-sm-2" style="padding-bottom:20px;">
                <div class="nav-url">
                  <ul class="nav nav-pills nav-stacked">
                      <li role="presentation"><?php echo Html::a('Account Balance',['user/userbalance'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation"><?php echo Html::a('Account History',['topup-history/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                      <li role="presentation" class="active"><a href="#" class="btn-block userprofile-edit-left-nav">Top Up</a></li>
                      <li role="presentation"><?php echo Html::a('Withdraw',['withdraw/index'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                  </ul>
                </div>
            </div>
            <div class="col-sm-10 right-side">
                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'amount') ?>

                    <?= $form->field($model, 'description') ?>
                    
                    <?= $form->field($model, 'bank_name')->dropDownList($name)?>

                    <?= $form->field($upload, 'imageFile')->fileInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>