<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

    $this->title = 'View Operate';
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mail Index'), 'url' => Yii::$app->request->referrer];
    $this->params['breadcrumbs'][] = $this->title;
?>
    <h1>Parcel ID <?= Html::encode($parid) ?></h1>
    <?= GridView::widget([

        'dataProvider' => $model,
        'columns' => [
            [
                'attribute' => 'newVal',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search New Operation',
                ],
            ],
            [
                'attribute' => 'oldVal',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Previous Operation',
                ],
            ],
            [
                'attribute' => 'type',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Type',
                ],
            ],
            [
                'attribute' => 'adminname',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Search Admin',
                ],
            ],
           'updated_at:datetime',
        ],
    ]); ?>


   