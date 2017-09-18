<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

    $this->title = 'Operation Record';
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Offline Topup'), 'url' => Yii::$app->request->referrer];
    $this->params['breadcrumbs'][] = $this->title;
?>
    <h1>OfflineTopup ID <?= Html::encode($tid) ?></h1>
    <?= GridView::widget([

        'dataProvider' => $model,
        'columns' => [
            'newVal',
            'oldVal',
            'type',
            'adminid',
           'updated_at:datetime',
        ],
    ]); ?>

	 <?= Html::a('Back', ['/finance/topup/index'], ['class'=>'btn btn-primary']) ?>


   