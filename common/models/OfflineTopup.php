<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offline_topup".
 *
 * @property integer $id
 * @property string $username
 * @property string $amount
 * @property string $description
 * @property string $action
 * @property string $inCharge
 * @property string $rejectReason
 * @property string $picture
 */
class OfflineTopup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_topup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'amount', 'picture'], 'required'],
            [['username', 'description', 'action', 'inCharge', 'rejectReason'], 'string'],
            [['amount'], 'number'],
            [['picture'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'amount' => 'Amount',
            'description' => 'Description',
            'action' => 'Action',
            'inCharge' => 'In Charge',
            'rejectReason' => 'Reject Reason',
            'picture' => 'Picture',
        ];
    }
}
