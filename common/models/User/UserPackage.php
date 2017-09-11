<?php

namespace common\models\User;

use Yii;
use common\models\Package;

/**
 * This is the model class for table "user_package".
 *
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
            [['uid', 'packid', 'sub_period'], 'integer'],
            [['code'], 'string'],
            [['subscribe_time', 'end_period'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'packid' => 'Package',
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

    public function getPackage()
    {
        return $this->hasOne(Package::classname(),['id' => 'packid']);
    }
}
