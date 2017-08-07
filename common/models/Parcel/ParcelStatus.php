<?php

namespace common\models\Parcel;

use Yii;

/**
 * This is the model class for table "parcel_status".
 *
 * @property integer $id
 * @property integer $parid
 * @property integer $status
 * @property integer $prestatus
 * @property integer $updated_at
 */
class ParcelStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parcel_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parid', 'status', 'prestatus', 'updated_at'], 'required'],
            [['parid', 'status', 'prestatus', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parid' => 'Parid',
            'status' => 'Status',
            'prestatus' => 'Prestatus',
            'updated_at' => 'Updated At',
        ];
    }
}
