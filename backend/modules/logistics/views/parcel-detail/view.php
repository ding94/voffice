<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Country */

$this->title = "Parcel ID ".$model->parid. " detail";
$this->params['breadcrumbs'][] = ['label' => 'Mail Index', 'url' => ['parcel/type-mail','status'=>$status]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-detail-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sender',
            'signer',
            'fulladdress',
            'fullcitycode',
            'weight',
        ],
    ]) ?>

     <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->parid ,'status' => $status], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
