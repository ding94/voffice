<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\db\ActiveRecord;
use iutbay\yii2fontawesome\FontAwesome as FA;


	$this->title = Yii::$app->user->identity->username.'Voucher List';
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?= Html::beginForm(['vouchers/batch'],'post');?>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                     [
                        'class' => 'yii\grid\SerialColumn',
                       
                    ],
    	            'vid',
    	            'code',
    	            'limitedTime',
        ]
    ])?>
    <?= Html::endForm();?> 
</div>


 