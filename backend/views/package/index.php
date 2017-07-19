<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\grid\GridView;

	$this->title = 'Package List';
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<h1><?= Html::encode($this->title)?></h1>

	<?= GridView::widget([
        'dataProvider' => $model,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type',
	        'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
