<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_package".
 *
 * @property integer $pay_id
 * @property integer $uid
 * @property integer $packid
 * @property string $code
 * @property string $subscribe_time
 * @property string $end_period
 * @property integer $sub_period
 */
class UserPackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'packid', 'subscribe_time', 'end_period', 'sub_period'], 'required'],
            [['pay_id', 'uid', 'packid', 'sub_period'], 'integer'],
            [['code'], 'string'],
            [['subscribe_time', 'end_period'], 'safe'],
            [['pay_id'],'default','value' => '1'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pay_id' => 'Pay ID',
            'uid' => 'Uid',
            'packid' => 'Packid',
            'code' => 'Code',
            'subscribe_time' => 'Subscribe Time',
            'end_period' => 'End Period',
            'sub_period' => 'Sub Period',
        ];
    }

    public static function primaryKey()
    {
        return ['uid'];
    }
}
