<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
<div class="row">
<div class="col-lg-4 col-lg-offset-4 " >
    <h1><?= Html::encode($this->title) ?></h1>

    <p><br>Please fill out the following fields to login:<br></p>
</div>
</div>
</div>
    <div class="row">
        
		<div class="col-lg-4 col-lg-offset-4 " >
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder' => "username or email"]) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => "password"]) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
				
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>