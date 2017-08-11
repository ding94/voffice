<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Country */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <p>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this User?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="user-detail-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           'id',
           'username',
           'email',
           [
                'attribute' => 'status',
                'value' => function($model)
                {
                    return $model->status == 10 ? 'Active' : 'Deactive';
                },

            ],
           'created_at:datetime',
           'updated_at:datetime',
           
        ],
    ]) ?>

   

</div>












