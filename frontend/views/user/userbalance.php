<?php
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\grid\ActionColumn;
/* @var $this yii\web\View */
?>

<div class="container">
	<div class="tab-content col-lg-6 col-lg-offset-1" id="userprofile">
		<table class="table table-user-information"><h1>User Balance</h1>
                <tbody>
                  <tr>
                    <td>My Balance:</td>
                    <td><?php echo $model['balance']; ?></td>
                  </tr>
               </tbody>
            </table>
            <a class="btn btn-md btn-warning" href="<?php echo yii\helpers\Url::to(['topup/index'])?>">Top Up</a>
            <a class="btn btn-md btn-warning" href="<?php echo yii\helpers\Url::to(['user/useredit'])?>">Withdraw</a>  
	</div>
</div>