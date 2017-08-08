<?php

namespace common\models\Parcel;

use Yii;
use common\models\Parcel\Parcel;

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
            [['parid', 'status', 'updated_at'], 'required'],
            [['parid', 'status', 'prestatus', 'updated_at'], 'integer'],
            [['parid'] ,'exist' ,
              'skipOnError' => true,
              'targetClass' => Parcel::className(),
              'targetAttribute' => ['parid' => 'id']]
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

    public function getParcel()
    {
        return $this->hasOne(Parcel::className(),['id' => 'parid']);
    }
}
