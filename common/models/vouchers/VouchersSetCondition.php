<?php

namespace common\models\vouchers;

use Yii;

/**
 * This is the model class for table "vouchers_set_condition".
 *
 * @property integer $id
 * @property integer $vid
 * @property integer $condition_id
 * @property string $amount
 */
class VouchersSetCondition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vouchers_set_condition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid'], 'required'],
            [['vid', 'condition_id'], 'integer'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vid' => 'Vid',
            'condition_id' => 'Condition ID',
            'amount' => 'Amount',
        ];
    }
}
