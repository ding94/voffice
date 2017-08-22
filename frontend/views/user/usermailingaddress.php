<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
/* @var $this yii\web\View */
?>

<div class="container">
<div class="row">
<div class="col-md-7 col-md-offset-1 " >
	<div class="tab-content" id="usermailingaddress">
		<table class="table table-user-information"><h1>User Mailing Address</h1>
                <tbody>
                  <tr>
                    <td>Address</td>
                    <td><?php echo $model['address1']; ?><br>
                    	<?php echo $model['address2']; ?><br>
                    	<?php echo $model['address3']; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Postcode</td>
                    <td><?php echo $model['postcode']; ?></td>
                  </tr>
                  <tr>
                    <td>State</td>
                    <td><?php echo $model['state']; ?></td>
                  </tr>
                  <tr>
                    <td>City</td>
                    <td><?php echo $model['city']; ?></td>
                  </tr>
                  <tr>
                    <td>Country</td>
                    <td><?php echo $model['country']; ?></td>
                  </tr>
                  <tr>
                    <td>Phone Number</td>
                    <td><?php echo $model['phonenumber']; ?></td>
                  </tr>
               </tbody>
            </table>
            <a class="btn btn-md btn-warning" href="<?php echo yii\helpers\Url::to(['user/usermailingaddressedit'])?>">Update</a>  
	</div>
</div>
</div>
</div>