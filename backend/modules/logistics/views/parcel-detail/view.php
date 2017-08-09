<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Country */

$this->title = "Parcel ID ".$model->parid. " detail";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mail Index'), 'url' => Yii::$app->request->referrer];
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
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->parid], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
