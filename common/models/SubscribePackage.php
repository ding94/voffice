<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscribe_package".
 *
 * @property integer $pay_id
 * @property integer $uid
 * @property double $amount
 * @property integer $package_type
 * @property integer $type
 * @property string $addTime
 */
class SubscribePackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribe_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'amount', 'package_type', 'type'], 'required'],
            [['uid', 'package_type', 'type'], 'integer'],
            [['amount'], 'number'],
            [['addTime'], 'safe'],
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
            'amount' => 'Amount',
            'package_type' => 'Package Type',
            'type' => 'Type',
            'addTime' => 'Add Time',
        ];
    }
}
