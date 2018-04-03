<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $paid_amount
 * @property integer $paid_type
 * @property integer $bank_acc
 * @property string $item
 * @property string $original_price
 * @property integer $voucher_id
 * @property integer $discount
 */
class Payment extends \yii\db\ActiveRecord
{
    public $coupon;
    public $code;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
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
            [['uid', 'paid_amount', 'paid_type', 'item', 'original_price'], 'required'],
            [['uid', 'paid_type', 'bank_acc', 'voucher_id', 'discount','created_at','updated_at'], 'integer'],
            [['paid_amount', 'original_price'], 'number'],
            [['item'], 'string'],
            [['coupon','code'],'string'],
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
            'paid_amount' => 'Paid Amount',
            'paid_type' => 'Paid Type',
            'bank_acc' => 'Bank Acc',
            'item' => 'Item',
            'original_price' => 'Original Price',
            'voucher_id' => 'Voucher ID',
            'discount' => 'Discount',
            'coupon' => 'Coupon',
        ];
    }
}
