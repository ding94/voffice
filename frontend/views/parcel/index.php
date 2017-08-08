<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;

?>
<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'=>$searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'parceldetail.sender',
                'parceldetail.signer',
                'parceldetail.address1',
                'parceldetail.address2',
                'parceldetail.address3',
                'parceldetail.postcode',
                'parceldetail.city',
                'parceldetail.state',
                'parceldetail.country',
                'parceldetail.weight',
                'status',
        ],
    ]); ?>
</div>