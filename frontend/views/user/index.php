<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
/* @var $this yii\web\View */
?>

<div class="container">
	<div class="tab-content" id="userprofile">
		<table class="table table-user-information"><h1>User Profile</h1>
                <tbody>
                  <tr>
                    <td>User Name:</td>
                    <td><?php echo $user['username']; ?></td>
                  </tr>
                  <tr>
                    <td>User Email</td>
                    <td><?php echo $user['email']; ?></td>
                  </tr>
                   <tr>
                    <td>Address</td>
                    <td><?php echo $usercontact['address1']; ?><br>
                    	<?php echo $usercontact['address2']; ?><br>
                    	<?php echo $usercontact['address3']; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Postcode</td>
                    <td><?php echo $usercontact['postcode']; ?></td>
                  </tr>
                  <tr>
                    <td>State</td>
                    <td><?php echo $usercontact['state']; ?></td>
                  </tr>
                  <tr>
                    <td>City</td>
                    <td><?php echo $usercontact['city']; ?></td>
                  </tr>
                  <tr>
                    <td>Country</td>
                    <td><?php echo $usercontact['country']; ?></td>
                  </tr>
                  <tr>
                    <td>Phone Number</td>
                    <td><?php echo $usercontact['phonenumber']; ?></td>
                  </tr>
               </tbody>
            </table>
            <a class="btn btn-md btn-warning" href="<?php echo yii\helpers\Url::to(['user/useredit'])?>">Update</a>  
	</div>
</div>