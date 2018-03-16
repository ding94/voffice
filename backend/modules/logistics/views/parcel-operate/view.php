<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\Admin;
use common\models\User\User;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

    $this->title = 'Operation Record';
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mail Index'), 'url' => Yii::$app->request->referrer];
    $this->params['breadcrumbs'][] = $this->title;
?>
    <h1>Parcel ID <?= Html::encode($parid) ?></h1>
    <?= GridView::widget([

        'dataProvider' => $model,
        'columns' => [
            'newVal',
            'oldVal',
            'type',
            [
                'attribute' => 'operatorType',
                'value'=> function($model){
                     return $model->operatorType == 1 ? 'Admin' : 'User';
                },
            ],
            [
                'label' => 'Operator Name',
                'attribute' => 'operatorID',
                'value'=> function($model){
                    $name = "";
                    if($model->operatorType == 1)
                    {
                        $name = Admin::findOne($model->operatorID)->adminname;
                    }
                    else
                    {
                         $name = User::findOne($model->operatorID)->username;
                    }
                    return $name;
                },
            ],
           'updated_at:datetime',
        ],
    ]); ?>


   