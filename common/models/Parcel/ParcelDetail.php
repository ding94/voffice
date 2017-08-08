<?php

namespace common\models\Parcel;

use Yii;
use common\models\Parcel\Parcel;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "parcel_detail".
 *
 * @property integer $parid
 * @property string $sender
 * @property string $signer
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property integer $postcode
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $weight
 */
class ParcelDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parcel_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parid', 'sender', 'signer', 'weight','address1','city','state','country', 'state', 'postcode'], 'required'],
            [['parid', 'postcode'], 'integer'],
            [['sender', 'signer', 'address1', 'address2', 'address3', 'city', 'state', 'country'], 'string'],
            [['weight'], 'number'],
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
            'parid' => 'Parid',
            'sender' => 'Sender',
            'signer' => 'Signer',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'address3' => 'Address3',
            'postcode' => 'Postcode',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'weight' => 'Weight',
        ];
    }

    public function getParcel()
    {
        return $this->hasOne(Parcel::className(),['id' => 'parid']);
    }
}
