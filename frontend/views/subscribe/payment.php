<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;

    $this->title = 'Payment Confirmation';
    $list = [1 => 'Account Balance'];
?>

<html>
<head></head><body>
<div class="container" style="padding-top: 200px">
	<div class="row">
		<div class="col-md-7 col-md-offset-1">
			<h1><?= Html::encode($this->title) ?></h1>
			<table class="table table-inverse">
            <tr>
                <th>Subscribe Package :</th>
                <th><?php echo $package['type']; ?></th>
            </tr>
            <tr>
                <td>Subscribe Period :</td>
                <td><?php echo $subscribe['sub_period']; ?></td>
            </tr>
            <tr>
                <td>Start Date :</td>
                <td><?php echo date('d F Y'); ?></td>
            </tr>
            <tr>
                <td>End Date :</td>
                <td><?php echo date('d F Y',strtotime($subscribe['sub_period'])); ?></td>
            </tr>
            <tr>
                <td>Next Payment On :</td>
                <td><?php echo date('d F Y',strtotime($subscribe['next_payment'])); ?></td>
            </tr>
            <tr>
                <td>Payment Price / time(s)     (RM) :</td>
                <td id="pakprice"><?php echo $package['price']; ?></td>
            </tr>
            <tr>
                <td>Total Price     (RM) :</td>
                <td id="totalprice"><?php echo $package['price'] * $subscribe['times']; ?></td>
            </tr>

            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($package, 'id')->hiddenInput()->label(false); ?>
            <?= $form->field($subscribe, 'id')->hiddenInput()->label(false); ?>
            <?= $form->field($payment, 'voucher_id')->hiddenInput()->label(false); ?>
            <tr>	
            	<td id="hide"> </td>
            	<td id="click"><a onclick="showHidden()"><font color="blue">Have a coupon ? Click Here</font></a></td>
            	

	            <td id="code" style="display : none">
		        	<?= $form->field($payment,'code')->textInput()->input('',['placeholder' => "Enter your coupon code"])->label(false) ?>
              <?= $form->field($payment,'coupon')->hiddenInput()->label(false)?>
		        </td>
		        <td>
		        	<a id="apply" style="display : none" onclick="discount()"><font color="blue">Apply</font></a>
		        </td>
		        <td id="reset" style="display : none"><a onclick="refresh()"><font color="blue">Reset Coupon</font></a></td>
		            
            </tr>

            <tr>
            	<td>Payment Method :</td>
                <td> <?php echo $form->field($payment, 'paid_type')->radioList($list)->label(false);  ?> </td>
            </tr>

			</table>
			<div class="form-group" >
			        <?= Html::submitButton('Subscribe', [
			        	'class' => 'btn btn-primary',
			        	'id' =>'subscribe',
			        	'onClick' => 'return confirm("Confirm Subscription?")',
						
			        ]) ?>
			   	
			<?php ActiveForm::end();?>
			<?= Html::a('Back', ['/subscribe/index'], ['class'=>'btn btn-info']) ?>
			</div>
			</div>
		</div>
	</div>


<script>
	 function showHidden()
  {
      document.getElementById("code").style.display ='block';
      document.getElementById("apply").style.display ='block';
      document.getElementById("hide").style.display = 'none';
      document.getElementById("click").style.display = 'none';
  }

  function discount()
  {
    //alert(parseInt(document.getElementById("totalprice").innerHTML));
  	$.ajax({
   url :"index.php?r=subscribe/getdiscount",
   type: "get",
   data :{
        code: document.getElementById("payment-code").value,
        pakprice: parseInt(document.getElementById("pakprice").innerHTML),
        total: parseInt(document.getElementById("totalprice").innerHTML),
   },
   success: function (data) {
      var obj = JSON.parse(data);
      //alert(obj['item']);
      if (obj['error'] == 0 ) {
        document.getElementById("pakprice").innerHTML = obj['package'];
        document.getElementById("totalprice").innerHTML = obj['total'];
        document.getElementById("payment-coupon").value = document.getElementById("payment-code").value ;
      }
      else if (obj['error'] == 1) {
        if (obj['item']==0) {
          alert('No coupon was found.Please check in your profile. (Profile > Voucher)');
          return false;
        }
        else if (obj['item']==1) {
          alert('Condition of coupon does not fulfilled.');
          return false;
        }
        else{
          alert('Something went wrong!');
          return false;
        }
      }
      else{
        alert('Something went wrong!');
        return false;
      }

     	//document.getElementById("payment-voucher_id").value = obj['id'] ;
		  document.getElementById("reset").style.display ='block';
    	document.getElementById("code").style.display ='none';
    	document.getElementById("apply").style.display ='none';
    	document.getElementById("click").style.display = 'none';	

   },
   error: function (request, status, error) {
    alert('Error!');
   }

   });
  }

  function refresh()
  {
  	location.reload();
  }
</script>

</body>
</html>