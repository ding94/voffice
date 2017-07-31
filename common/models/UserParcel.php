<?php

namespace common\models;
use yii\data\ActiveDataProvider;
use common\models\ParcelDetail;
use Yii;

/**
 * This is the model class for table "user_parcel".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $arrived_time
 * @property integer $user_notice
 * @property integer $parcel_sent
 * @property string $sent_time
 * @property string $received_time
 */
class UserParcel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_parcel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'user_notice', 'parcel_sent'], 'integer'],
            [['arrived_time', 'sent_time', 'received_time'], 'safe'],
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
            'arrived_time' => 'Arrived Time',
            'user_notice' => 'User Notice',
            'parcel_sent' => 'Parcel Sent',
            'sent_time' => 'Sent Time',
            'received_time' => 'Received Time',
        ];
    }

    public function getParceldetail()
    {
        return $this->hasOne(ParcelDetail::className(),['parid' => 'id']);
    }

    
}
