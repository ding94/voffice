<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
/* @var $this yii\web\View */
?>

<div class="container">
<div class="row">
<div class="col-md-7 col-md-offset-1 " >
	<div class="tab-content" id="usercompany">
		<table class="table table-user-information"><h1>User Company</h1>
                <tbody>
                  <tr>
                    <td>Company Name:</td>
                    <td><?php echo $model['cmpyName']; ?></td>
                  </tr>
                  <tr>
                    <td>Company Registration No.</td>
                    <td><?php echo $model['cmpyRegisNo']; ?></td>
                  </tr>
                  <tr>
                    <td>Company Type</td>
                    <td><?php echo $model['cmpyType']; ?></td>
                  </tr>
                  <tr>
                    <td>Industry</td>
                    <td><?php echo $model['industry']; ?></td>
                  </tr>
               </tbody>
            </table>
            <a class="btn btn-md btn-warning" href="<?php echo yii\helpers\Url::to(['user/usercompanyedit'])?>">Update</a>  
	</div>
</div>
</div>
</div>