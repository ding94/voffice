<?php

namespace common\models;

use Yii;
use common\models\User\User;
use common\models\Package;
use common\models\SubscribeType;

/**
 * This is the model class for table "subscribe_package_history".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $payid
 * @property string $amount
 * @property string $pay_date
 * @property integer $type
 * @property integer $packid
 * @property integer $subscribe_period
 * @property string $subscribe_date
 * @property string $end_date
 */
class SubscribePackageHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribe_package_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'payid', 'amount', 'pay_date', 'packid', 'subscribe_period', 'subscribe_date', 'end_date'], 'required'],
            [['uid', 'payid', 'pay_type', 'packid','pack_type','grade', 'subscribe_period'], 'integer'],
            [['amount'], 'number'],
            [['pay_date', 'subscribe_date', 'end_date'], 'safe'],
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
            'payid' => 'Payid',
            'amount' => 'Amount',
            'pay_date' => 'Pay Date',
            'pay_type' => 'Payment Type',
            'packid' => 'Packid',
			'pack_type'=>'Package Type',
			'grade'=>'Grade',
            'subscribe_period' => 'Subscribe Period',
            'subscribe_date' => 'Subscribe Date',
            'end_date' => 'End Date',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id' => 'uid']);
    }

    public function getPackage()
    {
        return $this->hasOne(Package::className(),['id' => 'packid']);
    }

    public function getSubscribeType()
    {
        return $this->hasOne(SubscribeType::className(),['id' => 'pack_type']);
    }
}
