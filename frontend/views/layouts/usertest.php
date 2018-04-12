<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\BowerAsset;
use common\widgets\Alert;
use kartik\widgets\SideNav;
use yii\helpers\Url;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
     <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body  id="page-top" class="index">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php 
    /*NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();*/
    ?>

		
	<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo yii\helpers\Url::to(['site/index'])?>">X MailBox<span><?php //echo $this->params['parcel']; ?></span></a>
                <a class="navbar-toggle" href="<?php echo yii\helpers\Url::to(['site/logout'])?>" data-method="post">
                    Logout
                </a>
            </div>
            <ul class="nav navbar-nav navbar-right hidden-xs">
                    <li>
                        <a class="page-scroll" href="<?php echo yii\helpers\Url::to(['site/logout'])?>" data-method="post">Logout</a>
                    </li>
            </ul>
            <!-- /.navbar-collapse -->           
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Side Nav -->

<div class="row">
    <div class="col-md-3 navbar" id="slide-nav" role="navigation" style="padding-top: 50px;">
        <div class="container">
        <div class="navbar-header">
        <a class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span><i class="glyphicon glyphicon-menu-hamburger"></i>
        </a>
        </div>
        </div>
    <div id="slidemenu">
    <?php echo SideNav::widget([
    //'type' => $type,
    'encodeLabels' => false,
    'options' => ['class' => 'in'],
    'items' => [
        ['label' => 'My Account', 'options' => ['class' => 'active'], 'items' => [
            ['label' => 'Account Balance', 'url' => Url::to(['user/userbalance'])],
            ['label' => 'Account History', 'url' => Url::to(['topup-history/index'])],
			
            ['label' => 'eVoucher', 'url' => Url::to(['user/uservouchers'])],
			['label' => 'My Package', 'url' => Url::to(['user/userpackage'])],
        ]],
        ['label' => 'Member Settings','options' => ['class' => 'active'], 'items' => [
            ['label' => 'User Profile', 'url' => Url::to(['user/index'])],
            ['label' => 'Change Password', 'url' => Url::to(['user/changepassword'])],
            ['label' => 'Mailing Address', 'url' => Url::to(['user/usermailingaddress'])],
            ['label' => 'Company Info', 'url' => Url::to(['user/usercompany'])],
        ]],
        ['label' => 'Parcel', 'options' => ['class' => 'active'], 'items' => [
            ['label' => 'My Mail', 'url' => Url::to(['parcel/index'])],
        ]],
        ['label' => 'News', 'options' => ['class' => 'active'], 'items' => [
            ['label' => 'News', 'url' => Url::to(['user/news-all'])],
        ]],
]]);     

?>
    </div>
    </div>
    <div id="page-content">
    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget([ 'options' => [
            'class' => 'alert-info flash-alert text-center alert-style',
            ],]); ?>
        <div class="content">
            <?= $content ?>
        </div>
    </div>
    </div>
</div>
</div>



		

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
<!-- Contact Form JavaScript -->
</body>
</html>
<?php $this->endPage() ?>
