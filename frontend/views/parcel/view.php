<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use kartik\widgets\ActiveForm;
use yii\widgets\DetailView;

use common\models\Parcel\ParcelStatusName;

?>
<div class="container">
	<h1><?= Html::encode($this->title) ?></h1>
		<?= DetailView::widget([
        'model' => $model,
		'attributes' => [
            
            'signer',
            'fulladdress',
			'postcode',
			'state',
			'country',
            'weight',
        ],
       
    ]) ?>
</div>