<?php

namespace common\models\User;

use Yii;

/**
 * This is the model class for table "user_package_subscription".
 *
 * @property integer $uid
 * @property string $end_period
 * @property string $next_payment
 */
class UserPackageSubscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_package_subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'end_period', 'next_payment'], 'required'],
            [['uid'], 'integer'],
            [['end_period', 'next_payment'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'end_period' => 'End Period',
            'next_payment' => 'Next Payment',
        ];
    }
}
