<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */
?>

<div class="profile">
  <div id="userprofile" class="row">
    <div class="userprofile-header">
      <div class="userprofile-header-title">User Profile</div>
    </div>
    <div class="userprofile-detail">
        <div class="col-sm-3 userprofile-left">
          <div class="userprofile-avatar">
              <?php 
                $picpath = Url::to('@web/img/DefaultPic.png');
              ?>
            
              <?php echo Html::img($picpath,['class'=>"userprofile-image"])?>
              <?= Html::a('Edit', ['user/useredit'], ['class'=>'btn btn-default userprofile-editbutton']) ?>
              <?= Html::a('Logout', ['/site/logout'], ['class'=>'btn btn-danger userprofile-logoutbutton','data-method'=>'post']) ?>
          </div>
        </div>
    </div>
        <div class="col-sm-9 userprofile-right">
          <h4><b>User Details</b></h4>
          <div class="userprofile-input">
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">Username: </div>
                  <div class="userprofile-text"><?php echo $user['username']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="userprofile-label">Email: </div>
                <div class="userprofile-text"><?php echo $user['email']; ?></div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">First Name: </div>
                  <div class="userprofile-text"><?php echo $userdetails['Fname']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">Last Name: </div>
                  <div class="userprofile-text"><?php echo $userdetails['Lname']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">Gender: </div>
                  <div class="userprofile-text"><?php echo $userdetails['gender']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">Date of Birth: </div>
                  <div class="userprofile-text"><?php echo $userdetails['DOB']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">IC/Passport: </div>
                  <div class="userprofile-text"><?php echo $userdetails['IC_passport']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">Address: </div>
                  <div class="userprofile-text"><?php echo $userdetails['address1']; ?>,</div>
                  <div class="userprofile-text"><?php echo $userdetails['address2']; ?>,</div>
                  <div class="userprofile-text"><?php echo $userdetails['address3']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">Postcode: </div>
                  <div class="userprofile-text"><?php echo $userdetails['postcode']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">City: </div>
                  <div class="userprofile-text"><?php echo $userdetails['city']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">State: </div>
                  <div class="userprofile-text"><?php echo $userdetails['state']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="inner-row">
                  <div class="userprofile-label">Country: </div>
                  <div class="userprofile-text"><?php echo $userdetails['country']; ?></div>
                </div>
              </div>
              <div class="row outer-row">
                <div class="userprofile-label">Phone Number: </div>
                <div class="userprofile-text"><?php echo $userdetails['phonenumber']; ?></div>
              </div>
          </div>
        </div>
  </div>
</div>