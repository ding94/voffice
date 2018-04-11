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
              
                if(is_null($userdetails->picture)) :

                  $picpath = Url::to('@web/img/DefaultPic.png');
                else :
                  if(file_exists(Yii::$app->params['userprofilepic'].$userdetails->picture)) :
                     $picpath = Url::to("@web/".Yii::$app->params['userprofilepic'].$userdetails->picture);
                  else :
                    $picpath = Url::to('@web/imageLocation/DefaultPic.png');
                  endif ;
                endif ;
              ?>
              <?php echo Html::img($picpath,['class'=>"userprofile-image"])?>
              <?= Html::a('Edit', ['user/useredit'], ['class'=>'btn btn-default userprofile-editbutton']) ?>
              <?= Html::a('Logout', ['/site/logout'], ['class'=>'btn btn-danger userprofile-logoutbutton','data-method'=>'post']) ?>
          </div>
        </div>
    </div>
        <div class="col-sm-9 userprofile-right">
          <h4><b>User Balance</b></h4>
          <div class="row outer-row">
              <div class="userprofile-label">RM <?= $balance['balance']?></div>
          </div>
        </div>
        <div class="col-sm-9 userprofile-right">
          <h4><b>User Details</b></h4>
          <div class="userprofile-input">
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
                  <div class="userprofile-text"><?= $userdetails['address1'].', '.$userdetails['address2'].', '.$userdetails['address3'].', '.$userdetails['postcode'].', '.$userdetails['city'].', '.$userdetails['state'].', '.$userdetails['country']; ?></div>
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