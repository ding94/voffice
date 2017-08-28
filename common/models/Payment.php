<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $pay_id
 * @property integer $uid
 * @property string $addTime
 * @property double $amount
 * @property integer $package_type
 * @property integer $type
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'amount', 'package_type', 'type'], 'required'],
            [['uid', 'package_type', 'type',], 'integer'],
            [['addTime'],'safe'],
            [['amount'], 'number'],
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
            'addTime' => 'Add Time',
            'amount' => 'Amount',
            'package_type' => 'Package Type',
            'type' => 'Type',
        ];
    }
}
