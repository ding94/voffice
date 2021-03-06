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
            'class' => 'alert-info flash-alert',
            'style' => 'position: absolute;
                        top: 30px;
                        right: 25%;
                        width: 50%;
                        z-index: 5000;',
            ],]); ?>
 <!-- <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div> -->
        <?= Yii::$app->session->getFlash('success');?>
    <!-- Header -->
    <header style="padding-top: 50px">
	
        

          <!-- <div class="intro-text">
                <div class="intro-lead-in">Welcome To Virtual Office!</div>
                <div class="intro-heading">Your Journey Begins Here</div>
                <a href="#about" class="page-scroll btn btn-xl">Tell Me More</a>
            </div>-->
					
			<h2 class="w3-center">Manual Slideshow</h2>

<div class="w3-content w3-display-container">
<div class="w3-display-middle btn-primary btn-lg"><a href="#about" class="page-scroll">Tell Me More</a></div>
  <?php
  foreach ($banner as $k => $banners) {
  ?>
    <a href="<?php echo $banners['redirectUrl'] ?>" target="_blank"><?= Html::img('@web/'.$banners['name'], ['class'=>'mySlides', 'style'=>"width:100%" , 'title' => $banners['title']]);?></a>
  <?php
    }
  ?>
  <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
  <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
</div>
	<br>
	<div style="text-align:center">
<?php foreach ($banner as $k => $banners) {
    $k += 1;
    ?>
<span class="dot" onclick="currentDivs($k)"></span>
<?php } ?>    
</div>
	
        <!-- container -->
		
		



    </header>
<!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">About</h2> 
                    <h3 class="section-subheading text-muted"><br><br>---<br><br><br><br>---<br><br><br><br>---<br><br>---</h3>
					
                </div>
            </div>
             <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Virtual Office helps...</p>
                </div>
              
             </div>
        </div>
    </section>
    <!-- Services Section -->
    <section id="services" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Services</h2>
                    <h3 class="section-subheading text-muted">---</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                         <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Administrative Support</h4>
                    <p class="text-muted">---</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                       <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Mail Received</h4>
                    <p class="text-muted">---</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Hardware Access</h4>
                    <p class="text-muted">---</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Grid Section -->
    <section id="portfolio" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Package</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?= Html::img('img/portfolio/roundicons.png',['class' => 'img-responsive']);?>
                    </a>
                    <div class="portfolio-caption">
                        <h4><?php echo $package[0]['type']; ?></h4>
                        <p class="text-muted">RM<?php echo $package[0]['price']; ?></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?= Html::img('img/portfolio/startup-framework.png',['class' => 'img-responsive']);?>
                    </a>
                    <div class="portfolio-caption">
                        <h4><?php echo $package[1]['type']; ?></h4>
                        <p class="text-muted">RM<?php echo $package[1]['price']; ?></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?= Html::img('img/portfolio/treehouse.png',['class' => 'img-responsive']);?>
                    </a>
                    <div class="portfolio-caption">
                        <h4><?php echo $package[2]['type']; ?></h4>
                        <p class="text-muted">RM<?php echo $package[2]['price']; ?></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal4" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?= Html::img('img/portfolio/golden.png',['class' => 'img-responsive']);?>
                    </a>
                    <div class="portfolio-caption">
                        <h4>Businessworld</h4>
                        <p class="text-muted">---</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal5" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?= Html::img('img/portfolio/escape.png',['class' => 'img-responsive']);?> 
                    </a>
                    <div class="portfolio-caption">
                        <h4>Office Space</h4>
                        <p class="text-muted">---</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a href="#portfolioModal6" class="portfolio-link" data-toggle="modal">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fa fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?= Html::img('img/portfolio/dreams.png',['class' => 'img-responsive']);?>
                    </a>
                    <div class="portfolio-caption">
                        <h4>Events</h4>
                        <p class="text-muted">---</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
     <!-- Contact Section -->
    <section id="contact">
        <div class="container">
		<!--<h1><?= Html::encode($this->title) ?></h1> -->
		<?php $form = ActiveForm::begin();?>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contact Us<br>
                  
                </h2>
				
				 <div class="text-center">
				 <p><font size="4" color="white"><i>Give us a call or send us an email and we will get back to you as soon as possible!</i></p><br>
                    <i class="fa fa-phone" style="font-size:50px;color:gold;"></i>
                    <p><font size="4" color="gold">123-456-789</font></p>
					<br>
					<p><font size="3" color="white">OR</font></p><br>
					<p><font size="4" color="gold">Leave Us Message</font></p><br>
                </div>
				</div>
            </div> 
		<div class="col-lg-8 col-lg-offset-2">
    	<?= $form->field($model, 'username') ?>
    	<?= $form->field($model, 'email') ?>
    	<?= $form->field($model, 'phone')  ?>
    	<?= $form->field($model, 'message')->textarea(['rows' => 1])?>
    	
    	
		 <div class="text-center">
    	<div class="form-group">
	        <?= Html::submitButton('Send', ['class' => 'btn btn-primary'])?>
	   </div>
	   	</div>
		</div>
	   </div>
	<?php ActiveForm::end();?>
			
           <!-- <div class="row">
                <div class="col-lg-12">
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                               <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name *" id="username" required data-validation-required-message="Please enter your name.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
								 
                             <button type="submit" class="btn btn-xl">Send Message</button>
							</div>
                               
                        </div> 
                    </form>
                </div>
            </div> -->
        </div>
    </section>
	

 
<!-- Portfolio Modals -->
    <!-- Use the modals below to showcase details about your portfolio projects! -->

    <!-- Portfolio Modal 1 -->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 portfolio-item">
                            <a href="#portfolioModal1" class="portfolio-link">
                                <?= Html::img('img/portfolio/roundicons.png',['class' => 'img-responsive']);?>
                            </a>
                            <div class="portfolio-caption">
                                <h4 class="package-name"><?php echo $package[0]['type']; ?></h4>
                                <p class="text-muted">RM<?php echo $package[0]['price']; ?></p>
                            </div>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <a href="<?php echo yii\helpers\Url::to(['/subscribe/index'])?>"><button type="button" class="btn btn-primary">Subscribe Package</button></a>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	 <!-- Portfolio Modal 2 -->
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 portfolio-item">
                            <a href="#portfolioModal2" class="portfolio-link">
                                <?= Html::img('img/portfolio/startup-framework.png',['class' => 'img-responsive']);?>
                            </a>
                            <div class="portfolio-caption">
                                <h4 class="package-name"><?php echo $package[1]['type']; ?></h4>
                                <p class="text-muted">RM<?php echo $package[1]['price']; ?></p>
                            </div>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <a href="<?php echo yii\helpers\Url::to(['/subscribe/index'])?>"><button type="button" class="btn btn-primary">Subscribe Package</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 3 -->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 portfolio-item">
                            <a href="#portfolioModal3" class="portfolio-link">
                                <?= Html::img('img/portfolio/treehouse.png',['class' => 'img-responsive']);?>
                            </a>
                            <div class="portfolio-caption">
                                <h4 class="package-name"><?php echo $package[2]['type']; ?></h4>
                                <p class="text-muted">RM<?php echo $package[2]['price']; ?></p>
                            </div>
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <a href="<?php echo yii\helpers\Url::to(['/subscribe/index'])?>"><button type="button" class="btn btn-primary">Subscribe Package</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 4 -->
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Businessworld</h2>
                                <p class="item-intro text-muted">---</p>
                                 <?= Html::img('img/portfolio/golden-preview.png',['class' => 'img-responsive img-centered']);?>
                                <p>--- <a href="https://www.behance.net/MathavanJaya">---</a>. ---</p>
                                <p>You can d---<a href="http://freebiesxpress.com/gallery/golden-free-one-page-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 5 -->
    <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Office Space</h2>
                                <p class="item-intro text-muted">---</p>
                                <?= Html::img('img/portfolio/escape-preview.png',['class' => 'img-responsive img-centered']);?>
                                <p>--- <a href="https://www.behance.net/MathavanJaya">---</a>. - --</p>
                                <p>You can --- <a href="http://freebiesxpress.com/gallery/escape-one-page-psd-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal 6 -->
    <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Events</h2>
                                <p class="item-intro text-muted">---</p>
                                 <?= Html::img('img/portfolio/dreams-preview.png',['class' => 'img-responsive img-centered']);?>
                                <p>--- <a href="https://www.behance.net/MathavanJaya">---</a>.---</p>
                                <p>You can--- <a href="http://freebiesxpress.com/gallery/dreams-free-one-page-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	

	

	