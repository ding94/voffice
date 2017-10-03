<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use iutbay\yii2fontawesome\FontAwesome as FA;
use yii\bootstrap\Modal;
use common\models\Package;
use kartik\widgets\ActiveForm;

$type = ArrayHelper::map(Package::find()->all(),'id','type');
$period = array(1 => 'Monthly',12 => 'Annual');
$fprice = $type['1'];
switch ($fprice) {
	case 1:
		$fprice = 100;
		break;
	
	default:
		$fprice = 100;
		break;
}
?>
<html><head></head><body>
<div class="container" style="padding-top: 200px">
	<div class="row">
		<div class="col-md-7 col-md-offset-1">
			<h1><?= Html::encode($this->title) ?></h1>
			<?php $form = ActiveForm::begin([
				'options'=>[
					'id'=>'form',
				],
				'action' => [
					'subscribe/make-subscribe',
				]
			]);?>
				<?= $form->field($subscribe, 'packid')->dropDownList($type,[
					'id'=>'package',
				]); ?>
				<?= $form->field($payment, 'paid_amount',['template' => '
		       		<div class="input-group" id="amount">
		          		<span class="input-group-addon">
		             		RM
		          		</span>
		          		{input}
		       		</div>
		       {error}{hint}'])->textInput([
		       		'readonly' => true,
		       		'value' =>$fprice,
					'options'=>[
						'id'=>'paid_amount',
					],
				]) ?>

				<div id='coupon' style="display: none"><?= $form->field($payment,'coupon')->textInput()->input('',['placeholder' => "Enter your coupon code"])?> </div><div id ="check" style="display: none"><a  onclick="discount()"><font color="blue">Apply</font></a></div>
				<div id ="click"><a onclick="showHidden()"><font color="blue">Have a coupon ? Click Me</font></a></div><br>


		       <?= $form->field($subscribe,'sub_period')->dropDownList($items) ?>
			  

		    	<div class="form-group">
			        <?= Html::submitButton('Subscribe', [
			        	'class' => 'btn btn-primary',
			        	'onClick' => 'return confirm("Confirm Subscription?")',
						
			        ]) ?>
			   </div>
			<?php ActiveForm::end();?>
		</div>
	</div>
</div>

<script >
  function showHidden()
  {
      document.getElementById("coupon").style.display ='block';
      document.getElementById("check").style.display ='block';
      document.getElementById("click").style.display = 'none';
  }

  function discounts()
  {
  	alert(document.getElementById("payment-coupon").value);
  }




  function discount()
  {
  	$.ajax({
   url :"index.php?r=subscribe/getdiscount",
   type: "get",
   data :{
        dis: document.getElementById("payment-coupon").value,
   },
   success: function (data) {
      var obj = JSON.parse(data);
      console.log(obj);
      if (obj['discount_type'] == 1) 
      {
      	if (obj['discount_item'] == 2) 
      	{
      		document.getElementById("payment-paid_amount").value = parseInt(document.getElementById("payment-paid_amount").value) *( (100 - obj['discount']) /100); 
      	}
      }
      else if (obj['discount_type'] == 2) 
      {
      	if (obj['discount_item'] == 2) 
      	{
      		document.getElementById("payment-paid_amount").value = parseInt(document.getElementById("payment-paid_amount").value) - obj['discount']; 
      	}
      }

      document.getElementById("coupon").style.display ='none';
      document.getElementById("check").style.display ='none';
      document.getElementById("click").style.display = 'none';
      
   },
   error: function (request, status, error) {
    //alert(request.responseText);
   }

   });
  }

  </script>

</body>
</html>