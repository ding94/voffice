<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
 <div class="row">
 <div class="col-lg-4 col-lg-offset-4 ">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><br>Please fill out the following fields to signup:<br></p>
</div>
</div>
    <div class="row">
       <div class="col-lg-4 col-lg-offset-4 " >
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group" style="display: inline;">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                <?php $authAuthChoice = yii\authclient\widgets\AuthChoice::begin([
                    'options' =>['style' => 'float:right;'],
                    'baseAuthUrl' => ['site/auth']
                    ]); ?>
                    <ul class="auth-clients">
                        <?php foreach ($authAuthChoice->getClients() as $client): ?>
                            <li><?= $authAuthChoice->clientLink($client,
                                '<span class="fa fa-'.$client->getName().'"></span> Sign up with '.$client->getTitle(),
                                [
                                    'class' => 'btn btn-block btn-social btn-'.$client->getName(),
                                    ]) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php yii\authclient\widgets\AuthChoice::end(); ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>