<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\User\User;
use backend\models\Admin;

/**
 * This is the model class for table "account_force".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $amount
 * @property integer $reduceOrPlus
 * @property string $reason
 * @property integer $created_at
 * @property integer $updated_at
 */
class AccountForce extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_force';
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
            [['uid', 'amount', 'reduceOrPlus', 'reason','adminid'], 'required'],
            [['uid', 'reduceOrPlus', 'created_at', 'updated_at','adminid'], 'integer'],
            [['amount'], 'number'],
            ['amount' ,'compare','compareValue' => 500 ,'operator' => '<='],
            [['reason'], 'string', 'max' => 255],
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
            'amount' => 'Amount',
            'reduceOrPlus' => 'Reduce Or Plus',
            'reason' => 'Reason',
            'adminid' => 'Admin ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'uid']);
    }

    public function getAdmin(){
        return $this->hasOne(Admin::className(),['id'=>'adminid']);
    }
}
