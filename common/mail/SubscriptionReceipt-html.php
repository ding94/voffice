<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="password-reset">
    <h4>Subscription Successful!</h4>
</div>

<div class="container">
	<div class="tab-content col-md-6 col-md-offset-1" id="userprofile">
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
	</div>
</div>
