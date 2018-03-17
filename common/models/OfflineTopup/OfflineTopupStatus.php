<?php

namespace common\models\OfflineTopup;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "offline_topup_status".
 *
 * @property integer $id
 * @property string $description
 * @property string $showName
 * @property integer $created_at
 * @property integer $updated_at
 */
class OfflineTopupStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_topup_status';
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
            [['id', 'title'], 'required'],
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string'],
        ];
    }
	
	public function getOfflinetopupstatus()
    {
        return $this->hasOne(OfflineTopup::className(),['action' => 'id']); 
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Status Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
