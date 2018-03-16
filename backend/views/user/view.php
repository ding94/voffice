<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Country */

$this->title = $user->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <p>
        <?= Html::a(Yii::t('app', 'Deactivate'), ['delete', 'id' => $user->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to deactivate this User?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

<div class="user-detail-view">

    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
           'username',
           'email',
            [
                'attribute' => 'status',
                'value' => function($model)
                {
                    return $model->status == 10 ? 'Active' : 'Deactive';
                },

            ],
            'userdetail.fullname',
            'userdetail.company.cmpyName',
            'created_at:datetime',
            'updated_at:datetime', 
        ],
    ]) ?>
   
   <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'type',
                'value' => function($model)
                {
                    return $model->type ==1 ? 'Mail' : 'Parcel';
                },
                'filter' => array( "1"=>"Mail","2"=>"Parcel"),
            ],
            [
                 'attribute' => 'Status',
                'value' => 'parcelstatusname.description',
                'filter' => $list,
            ]
            
        ],

    ]); ?>

</div>












