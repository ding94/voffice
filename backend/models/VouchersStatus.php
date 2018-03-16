<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vouchers_status".
 *
 * @property integer $id
 * @property string $description
 * @property string $type
 */
class VouchersStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vouchers_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }
}
