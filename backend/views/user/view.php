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
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this User?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div id="reward">
        <table class="table">
            <tr>
                <th class="success game-rule-tr">Username</th>
                <th class="success game-rule-tr"><?php echo $model->username ?></th>
            </tr>
            <tr class="reward-table-tr">
                <td>E-mail</td>
                <td><?php echo $model->email ?></td>
            </tr>
            <tr class="reward-table-tr">
                <td>Status</td>
                <td><?php echo $model->status ?></td>
            </tr>
            <?php if (!empty($pid)) { ?>

            <tr class="reward-table-tr">
                <td>Number of Parcel</td>
                <td><?php 
                        $count=0;
                        foreach ($pid as $parcel) { $count +=1; }
                        echo $count; 
                    ?>
                </td>
            </tr>
            <tr class="reward-table-tr">
                <td>Parcel ID</td>
                <td>
                    <?php  
                        foreach ($pid as $parcel) {
                            echo $parcel->id;
                            ?><br><?php
                        }
                    ?>
                </td>
            </tr>
            <?php }?>


        </table>
    </div>












