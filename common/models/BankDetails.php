<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "bank_details".
 *
 * @property integer $id
 * @property string $bank_account
 * @property string $bank_name
 * @property integer $created_at
 * @property integer $update_at
 */
class BankDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank_details';
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
            [['bank_name', 'created_at', 'update_at'], 'required'],
            [['bank_name'], 'string'],
            [['created_at', 'update_at'], 'integer'],
            [['bank_account'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_account' => 'Bank Account',
            'bank_name' => 'Bank Name',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
        ];
    }
}
