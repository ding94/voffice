<?php

namespace common\models\User;

use Yii;

/**
 * This is the model class for table "user_package".
 *
 * @property integer $uid
 * @property integer $packid
 * @property string $code
 * @property integer $create_time
 * @property string $end_period
 * @property integer $sub_period_month
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
            [['uid', 'packid', 'code', 'create_time', 'end_period', 'sub_period_month'], 'required'],
            [['uid', 'packid', 'create_time', 'sub_period_month'], 'integer'],
            [['code'], 'string'],
            [['end_period'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'packid' => 'Packid',
            'code' => 'Code',
            'create_time' => 'Create Time',
            'end_period' => 'End Period',
            'sub_period_month' => 'Sub Period Month',
        ];
    }
}
