<?php

namespace common\models\Parcel;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\ParcelOperate;
use common\models\Parcel\ParcelStatus;

/**
 * This is the model class for table "parcel".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $type
 * @property integer $status
 * @property integer $updated_at
 */
class Parcel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parcel';
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
            [['uid', 'type', 'status'], 'required'],
            [['uid', 'status', 'updated_at','created_at' ,'type'], 'integer'],
            [['type'],'in', 'range' => [1, 2]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Create At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getParceldetail()
    {
        return $this->hasOne(ParcelDetail::className(),['parid' => 'id']); 
    }

    public function getParceloperate()
    {
        return $this->hasMany(ParcelOperate::className(),['parid' => 'id']); 
    }

    public function getParcelstatus()
    {
        return $this->hasMany(ParcelStatus::className(),['parid' => 'id']); 
    }
}
