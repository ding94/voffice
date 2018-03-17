<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
/* @var $this yii\web\View */
?>
<div class="container">
	<div class="tab-content col-md-7 col-md-offset-1" id="userprofile">
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
                    <td>First Name</td>
                    <td><?php echo $userdetails['Fname']; ?></td>
                  </tr>
                  <tr>
                    <td>Last Name</td>
                    <td><?php echo $userdetails['Lname']; ?></td>
                  </tr>
                  <tr>
                    <td>Gender</td>
                    <td><?php echo $userdetails['gender']; ?></td>
                  </tr>
                  <tr>
                    <td>Date of Birth</td>
                    <td><?php echo $userdetails['DOB']; ?></td>
                  </tr>
                  <tr>
                    <td>IC/Passport</td>
                    <td><?php echo $userdetails['IC_passport']; ?></td>
                  </tr>
                   <tr>
                    <td>Address</td>
                    <td><?php echo $userdetails['address1']; ?><br>
                    	<?php echo $userdetails['address2']; ?><br>
                    	<?php echo $userdetails['address3']; ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Postcode</td>
                    <td><?php echo $userdetails['postcode']; ?></td>
                  </tr>
                  <tr>
                    <td>State</td>
                    <td><?php echo $userdetails['state']; ?></td>
                  </tr>
                  <tr>
                    <td>City</td>
                    <td><?php echo $userdetails['city']; ?></td>
                  </tr>
                  <tr>
                    <td>Country</td>
                    <td><?php echo $userdetails['country']; ?></td>
                  </tr>
                  <tr>
                    <td>Phone Number</td>
                    <td><?php echo $userdetails['phonenumber']; ?></td>
                  </tr>
               </tbody>
            </table>
            <a class="btn btn-md btn-warning" href="<?php echo yii\helpers\Url::to(['user/useredit'])?>">Update</a>  
	</div>
</div>