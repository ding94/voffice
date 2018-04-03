<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use common\widgets\Alert;
use kartik\widgets\Select2;
use common\models\Country;
use yii\helpers\ArrayHelper;

$country = Country::find()->all();
$data = ArrayHelper::map($country,'name_en','name_en');

/* @var $this yii\web\View */
?>

<div class="profile">
    <div id="userprofile" class="row">
   <div class="userprofile-header">
        <div class="userprofile-header-title"><?php echo Html::encode($this->title)?></div>
    </div>
    <div class="userprofile-detail">
        <div class="col-sm-2">
            <div class="nav-url">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation" class="active"><a href="#" class="btn-block userprofile-edit-left-nav">Edit User Profile</a></li>
                    <li role="presentation"><?php echo Html::a('Change Password',['user/changepassword'],['class'=>'btn-block userprofile-edit-left-nav'])?></li>
                </ul>
            </div>
        </div>
    </div>
        <div class="col-sm-8 userprofile-edit-input">
            <?php $form = ActiveForm::begin();?>
				<?= $form->field($model, 'Fname')->textInput() ?>
				<?= $form->field($model, 'Lname')->textInput() ?>
				<?= $form->field($model, 'gender')->radioList(array('Male'=>'Male','Female'=>'Female')); ?>
				<?= $form->field($model, 'DOB')->widget(DatePicker::classname(), [
				    'options' => ['placeholder' => 'Enter birth date ...'],
				    'pluginOptions' => [
				    	'todayHighlight' => true,
		        		'todayBtn' => true,
				    	'format' => 'yyyy-mm-dd',
				        'autoclose'=>true,
				        'endDate'=>date('Y/m/d',strtotime('-1 day'))
				    ]
				]) ?>
				<?= $form->field($model, 'IC_passport')->textInput() ?>
		    	<?= $form->field($model, 'address1')->textInput() ?>
		    	<?= $form->field($model, 'address2')->textInput() ?>
		    	<?= $form->field($model, 'address3')->textInput() ?>
		    	<?= $form->field($model, 'postcode')->textInput() ?>
		    	<?= $form->field($model, 'state')->textInput() ?>
		    	<?= $form->field($model, 'city')->textInput() ?>
		    	<?= $form->field($model, 'country')->dropDownList($data) ?>
		    	<?= $form->field($model, 'phonenumber')->textInput() ?>
		    	<div class="form-group">
			        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
			   </div>
			<?php ActiveForm::end();?>
        </div>
    </div>
</div>