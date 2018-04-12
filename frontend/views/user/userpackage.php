<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
?>
<div class="userpackage">
    <div id="userprofile" class="row">
       <div class="userprofile-header">
            <div class="userprofile-header-title">User Package</div>
        </div>
        <div class="topup-detail">
            <div class="col-sm-2" style="padding-bottom:20px;">
            </div>
            <div class="col-sm-10 right-side">
				<table class="table table-user-information"><h1>User Package</h1>
	                <tbody>
	                  <tr>
	                    <td>My Package:</td>
	                    <td><?php echo $model['package']['type']; ?></td>
					</tr>
					<tr>
	                    <td>Package Price (RM):</td>
						 <td><?php echo $model['package']['price']; ?></td>
					</tr>
					<tr>
	                    <td>Subscribe Period (days):</td>
					<td><?php echo $model['sub_period']; ?></td>
						</tr>
						<tr>
	                    <td>Subscription Starts On:</td>
					<td><?php echo $model['subscribe_time']; ?></td>
						</tr>
					<tr>
	                    <td>Subscription Ends On:</td>
						<td><?php echo $model['end_period']; ?></td>
					</tr>
	               </tbody>
	            </table>
					
				<table class="table table-user-information"><h3>Package Status</h3>
	                <tbody>
	                  <tr>
	                    <td>My Package:</td>
	                    <td><?php echo $subscribetype; ?></td>
					</tr>
					<tr>
	                    <td>Next Payment:</td>
						<td><?php echo $userpackagesubscription['next_payment']; ?></td>
					</tr>
					</tr>
	               </tbody>
	            </table>
				
	       
				<a class="btn btn-md btn-primary" href="<?php echo yii\helpers\Url::to(['subscribe/index'])?>">Pay Now</a>
            </div>
        </div>
    </div>
</div>



