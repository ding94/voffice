<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Platinum';
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="container">

	 <div class="col-lg-5 col-lg-offset-5">
	  
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Welcome to XMailbox!</p>

 
   <!-- Modal 1 -->
   
       
                  <img class="img-fluid d-block mx-auto" src="../web/img/portfolio/roundicons.png" alt=""><br><br>
				 
				   
				 <table>
				  <tbody>
                <tr>
                  Date: January 2017</tr><br><br>
                   <tr>Client: Threads</tr><br><br>
                   <tr>Category: Illustration</tr><br><br>
				    </tbody>
                	 </table>
              <div class="form-group">
	        <?= Html::submitButton('Pay', [
	        	'class' => 'btn btn-primary',
	        	'onClick' => 'return confirm("Confirm Subscription?")',
				
	        ]) ?>
	   </div>
              <a class="btn btn-md btn-primary" href="<?php echo yii\helpers\Url::to(['user/userpackage'])?>">Upgrade</a>
              </div>
			  
            </div>
        