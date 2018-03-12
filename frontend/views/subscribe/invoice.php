<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;

    $this->title = 'Invoice';
?>
<div class="container" style="padding-top: 200px">
	<div class="row">
		<div class="col-md-7 col-md-offset-1">
			<h1 align="right"><?= Html::encode($this->title) ?></h1>
			<h1 align="left">X-MailBox</h1>
			<table class="table table-inverse">
            <tr>
                <td>(Address)</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>(Address)</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            	<td></td>
            	<td></td>	
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Payment ID :</td>
                <td><?php echo $payment['id']; ?></td>
                <td>Payment Time :</td>
                <td><?php echo date('Y-m-d',$payment['created_at']); ?></td>
            </tr>
            <tr>
                <td>User :</td>
                <td><?php echo Yii::$app->user->identity->username ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>User's Company:</td>
                <td>(User Company's Name)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Subscribed Package :</td>
                <td><?php echo $package->packid; ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Subscribed Date :</td>
                <td><?php echo $package->subscribe_time; ?></td>
                <td>Subscribed Date :</td>
                <td><?php echo $package->subscribe_time; ?></td>
            </tr>

            <tr>
            	<td>Subscribe Ends On :</td>
            	<td><?php echo $next->end_period; ?></td>
            	<td>Next Payment On :</td>
            	<td><?php echo $next->next_payment; ?></td>
            </tr>
            <tr>
            	<td>Original Price :</td>
            	<td><?php echo $payment->original_price; ?></td>
            	<td>Total Paid :</td>
            	<td><?php echo $payment->paid_amount; ?></td>
            </tr>
            <?php if (!empty($voucher)) {  ?>
            	<tr>
            	<td>Coupon :</td>
            	<td><?php echo $voucher->code; ?></td>
            	<td>Total Discount :</td>
            	<td><?php echo $payment->discount; ?></td>
            </tr>
           <?php } ?>
            
        </table>

        <?= Html::a('Done', ['/subscribe/index'], ['class'=>'btn btn-info']) ?>
		</div>
	</div>
</div>