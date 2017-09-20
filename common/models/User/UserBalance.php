<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_balance".
 *
 * @property integer $uid
 * @property integer $balance
 * @property integer $positive
 * @property integer $negative
 */
class UserBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'balance' ], 'required'],
			[['positive'],'required', 'on' => ['positive']],
			[['negative'],'required', 'on' => ['negative']],
            [['uid', 'balance', 'positive', 'negative'], 'integer'],
            [['balance'],'default','value' => '0'],
            ['balance', 'compare', 'compareValue' => 0, 'operator' => '>'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'balance' => 'Balance',
            'positive' => 'Positive',
            'negative' => 'Negative',
        ];
    }
}
