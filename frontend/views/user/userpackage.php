<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
?>

<div class="container">
	<div class="tab-content col-md-6 col-md-offset-1" id="userprofile">
		<table class="table table-user-information"><h1>User Package</h1>
                <tbody>
                  <tr>
                    <td>My Package:</td>
                    <td><?php echo $model['packid']; ?></td>
				</tr>
				<tr>
                    <td>Subscribe Period (months):</td>
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
            <a class="btn btn-md btn-info" href="<?php echo yii\helpers\Url::to(['package/index'])?>">Renew</a>
      
			
			
	</div>
</div>