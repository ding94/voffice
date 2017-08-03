<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_voucher".
 *
 * @property integer $uid
 * @property integer $vid
 * @property string $code
 * @property integer $limitedTime
 */
class UserVoucher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_voucher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'vid', 'code', 'limitedTime'], 'required'],
            [['uid', 'vid', 'limitedTime'], 'integer'],
            [['code'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'vid' => 'Vid',
            'code' => 'Code',
            'limitedTime' => 'Limited Time',
        ];
    }
}
