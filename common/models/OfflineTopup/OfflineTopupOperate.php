<?php

namespace common\models\OfflineTopup;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\OfflineTopup\OfflineTopup;

/**
 * This is the model class for table "offlinetopup_operate".
 *
 * @property integer $id
 * @property integer $parid
 * @property string $adminname
 * @property integer $oldVal
 * @property integer $newVal
 * @property integer $update_at
 */
class OfflineTopupOperate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_topup_operate';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],   
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid', 'adminname', 'newVal'], 'required'],
            [['tid','created_at', 'updated_at'], 'integer'],
            [['adminname','oldVal', 'newVal','type'], 'string', 'max' => 20],
            [['tid'] ,'exist' ,
              'skipOnError' => true,
              'targetClass' => OfflineTopup::className(),
              'targetAttribute' => ['tid' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tid' => 'Topup id',
            'adminname' => 'Admin name',
            'type' => 'type',
            'oldVal' => 'Old record',
            'newVal' => 'New record',
            'updated_at' => 'Update At',
        ];
    }

    
}
