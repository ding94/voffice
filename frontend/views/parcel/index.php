<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\models\Parcel\ParcelStatusName;

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
                [
                    'attribute' => 'status',
                    'value' => 'parcelstatusname.description',
                    'filter'=>Html::activeDropDownList($searchModel,'status',ArrayHelper::map(ParcelStatusName::find()->asArray()->all(), 'id', 'description'),['class'=>'form-control']),
                    //'filter'=>ArrayHelper::map(ParcelStatusName::find()->asArray()->all(), 'id', 'description'),
                ],
        ],
    ]); ?>
</div>