<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $user common\models\User */
$confirmLink = Url::to(['site/confirm','id' => $id, 'auth_key' => $auth_key],true);
AppAsset::register($this);
?>
<style>
.password-reset{
	font-family: "Verdana","Arial",Sans-serif; 
	display: block;
	border: 1px solid #ffbe61;
	width: 75%;
	-webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    padding: 30px;
}

.password-reset h1{
	text-align: center;
}

.password-reset p{
	text-align: center;
}

.password-reset a{
	padding: 10px 15px;
	background: #FF8300;
	color: #FFF;
	text-decoration: none;
	-webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
}

.password-reset .verify-button{
	text-align: center;
}
</style>

<div class="password-reset">
	<h1>Welcome to Voffice!</h1>
	<hr style="width:40%; border-bottom: 1px solid grey;" >
	<p>To start using all features of the website, please verify your email address.</p>
	<p>If you did not create an account with us using this address, please contact us at xxxx@voffice.com</p>
    <p>Your confirmation link: </p>
    <div class="verify-button"><?= Html::a('Verify your account', $confirmLink) ?></div>
</div>
