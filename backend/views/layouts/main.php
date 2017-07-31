<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use kartik\alert\AlertBlock;
use kartik\widgets\SideNav;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Voffice backend',
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Admin List' , 'url' => ['/admin/index']];
        $menuItems[] = ['label' => 'Auth List' , 'url' => ['/auth/index']];
        $menuItems[] = ['label' => 'User' , 'url' => ['/user/index']];
        $menuItems[] = ['label' => 'User Parcel' , 'url' => ['/user/user-parcel']];
        $menuItems[] = ['label' => 'Setting' ,
                        'items' => [
                            ['label' => 'change password' , 'url' => ['/admin/changepass' ,'id' => Yii::$app->user->identity->id]],
                        ]];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->adminname . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    
    
    <div class="container">
    <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php echo AlertBlock::widget([
            'type' => AlertBlock::TYPE_ALERT,
            'useSessionFlash' => true
        ]);?>
    <div class="row">
        <div class="col-xs-5 col-sm-4 col-lg-3">
            <?php
            if (Yii::$app->user->isGuest) {
                 echo SideNav::widget([
                    'items' => [
                    ['label' => 'Login', 'url' => Url::to(['/site/login'])]
                    ]

                    ]);
             } 
            else {
                echo SideNav::widget([
        'encodeLabels' => false,
        'items' => [
            ['label' => 'Admin List', 'url' => Url::to(['/admin/index'])],
            ['label' => 'Auth List', 'url' => Url::to(['/auth/index'])],
            ['label' => 'User', 'url' => Url::to(['/user/index'])],
            ['label' => 'User Parcel', 'url' => Url::to(['/user/user-parcel'])],
            ['label' => 'Auth List', 'url' => Url::to(['/auth/index'])],
            ['label' => 'Setting', 'items' => [
                ['label' => 'change password', 'url' => Url::to(['/admin/changepass'])
                ]]
            
        ],
    ]]);
            }
    
    ?>
        </div>
        <div class="col-xs-7 col-sm-8 col-lg-9">
            <?= $content ?>
        </div>
    </div>
        
        
        
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
