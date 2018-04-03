<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;
use yii\bootstrap\Modal;



$this->title = 'Virtual Office';
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?= Alert::widget([ 'options' => [
            'class' => 'alert-info',
            'style' => 'position: absolute;
                        top: 30px;
                        right: 25%;
                        width: 50%;
                        z-index: 5000;',
            ],]); ?>
        <?= Yii::$app->session->getFlash('success');?>
    <!-- Header -->
    <header>

        <div class="header-container">
            <div class="header-img">
                <?= Html::img('@web/img/header.jpg');?>
            </div>
            <div class="header-info">
                <div class="info-text">
                    <span>Workspace for Creatives</span>
                </div>
                <div class="info-button btn btn-primary">
                    <span>Book a Tour Now</span><i class="fa fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </header>
<!-- About Section -->
    <section id="about">
        <div class="about-container">
            <div class="about-text-container">
                <h3>About Voffice</h3>
                <p>Loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum</p>
                <div class="btn btn-primary">Book Tour</div>
            </div>
        </div>
        <div class="img-slider-container">
            <div class="img-slider">
                <div><?= Html::img('@web/img/slide-1.jpg');?></div>
                <div><?= Html::img('@web/img/slide-2.jpg');?></div>
                <div><?= Html::img('@web/img/slide-3.jpg');?></div>
            </div>
        </div>
    </section>
    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Services</h2>
                    <h3 class="section-subheading text-muted">The services and facilities that we provide to our members:</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                         <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Administrative Support</h4>
                    <p class="text-muted">loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                       <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Receive Mail</h4>
                    <p class="text-muted">loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Hardware Access</h4>
                    <p class="text-muted">loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-wifi fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Fast Internet</h4>
                    <p class="text-muted">loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Office Supplies</h4>
                    <p class="text-muted">loren ipsum loren ipsum loren ipsum loren ipsum </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Meeting and Conference Rooms</h4>
                    <p class="text-muted">loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Grid Section -->
    <section id="packages">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Plans & Pricing</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row package-container">
                <div class="package-div silver-border">
                    <div class="silver package-header-container">
                        <div class="header-div text-center">
                            <h2><?php echo $package[0]['type']; ?></h2>
                            <p>RM<?php echo $package[0]['price']; ?>/ month</p>
                        </div>
                    </div>
                    <div class="triangle-shape-silver"></div>
                    <div class="package-info-container text-center">
                        <p>loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum</p>
                    </div>
                    <div class="divider silver"></div>
                    <div class="package-info-list-container">
                        <ul>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                        </ul>
                    </div>
                    <div class="package-btn silver package-btn-silver-hover">Subscribe Now</div>
                </div>
                <div class="package-div gold-border">
                    <div class="gold package-header-container">
                        <div class="header-div text-center">
                            <h2><?php echo $package[1]['type']; ?></h2>
                            <p>RM<?php echo $package[1]['price']; ?>/ month</p>
                        </div>
                    </div>
                    <div class="triangle-shape-gold"></div>
                    <div class="package-info-container text-center">
                        <p>loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum</p>
                    </div>
                    <div class="divider gold"></div>
                    <div class="package-info-list-container">
                        <ul>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                        </ul>
                    </div>
                    <div class="package-btn gold package-btn-gold-hover">Subscribe Now</div>
                </div>
                <div class="package-div platinum-border">
                    <div class="platinum package-header-container">
                        <div class="header-div text-center">
                            <h2><?php echo $package[2]['type']; ?></h2>
                            <p>RM<?php echo $package[2]['price']; ?>/ month</p>
                        </div>
                    </div>
                    <div class="triangle-shape-platinum"></div>
                    <div class="package-info-container text-center">
                        <p>loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum</p>
                    </div>
                    <div class="divider platinum"></div>
                    <div class="package-info-list-container">
                        <ul>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                            <li>loren ipsum</li>
                        </ul>
                    </div>
                    <div class="package-btn platinum package-btn-platinum-hover">Subscribe Now</div>
                </div>
            </div>
    </section>
   
    <!-- Contact Section -->
    <section id="contact">
        <h2 class="section-heading text-center">Contact Us</h2>
        <div class="container-fluid">
            <!--<h1><?= Html::encode($this->title) ?></h1> -->
            <div class="location-container">
                <div>
                    <div><h2>Find Us at Medini 6</h2></div>
                    <div><p>Loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum loren ipsum</p></div>
                </div>
                <iframe width="600" height="700" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJmfMVOPQL2jER0rG3llIcP2c&key=AIzaSyBb8GwvmSM3KrX5hxDJcI9QiXUE0WoIcAY" allowfullscreen></iframe>
            </div>
            <div>
                <div class="row contact-text-container">
                    <div class="col-lg-8 text-center">
                        <br>
                        <div class="text-center">
                        <p><font size="4" color="white"><i>Give us a call or send us an email and we will get back to you as soon as possible!</font></i></p><br>
                        <i class="fa fa-phone" style="font-size:50px;color:gold;"></i>
                        <p><font size="4" color="gold">123-456-789</font></p>
                        <br>
                        <p><font size="3" color="white">OR</font></p><br>
                        <p><font size="4" color="gold">Leave Us Message</font></p><br>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-10 col-lg-offset-2">
                    <?php $form = ActiveForm::begin();?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'phone')  ?>
                    <?= $form->field($model, 'message')->textarea(['rows' => 1])?>

                    <div class="text-center">
                        <div class="form-group">
                            <?= Html::submitButton('Send', ['class' => 'btn btn-primary'])?>
                        </div>
                    </div>
                    <?php ActiveForm::end();?>
                </div>
            </div>
        </div>
    </section>

    <!--Start of Tawk.to Script-->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5ab85ab44b401e45400e09ea/1c9g2v8qt';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<!--End of Tawk.to Script-->
