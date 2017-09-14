<?php

namespace common\models\Parcel;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\ParcelOperate;
use common\models\Parcel\ParcelStatus;
use common\models\User\User;
use common\models\User\UserDetails;
use common\components\NotificationBehavior;

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
    const PENDING         = 1;
    const PENDING_PICK_UP = 2;
    const SENDING         = 3;
    const CONFIRM_RECEIVE = 4;
    const EARLY_POSTAL    = 5;
    const PENDING_EARLY   = 6;

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
            NotificationBehavior::className(),
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

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=> 'uid']);
    }

    public function getUserdetail()
    {
        return $this->hasOne(UserDetails::className(),['uid' => $this->user->id]);
    }

    public function getParcelstatusname()
    {
        return $this->hasOne(ParcelStatusName::className(),['id' => 'status']);
    }
}
