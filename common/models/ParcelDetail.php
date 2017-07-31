<?php

namespace common\models;
use yii\data\ActiveDataProvider;
use common\models\UserParcel;
use Yii;

/**
 * This is the model class for table "parcel_detail".
 *
 * @property integer $parid
 * @property string $sender
 * @property string $signer
 * @property string $signer_ic
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property integer $postcode
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $weight
 * @property string $size
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
            
            [['parid', 'postcode'], 'integer'],
            [['sender', 'signer', 'address1', 'address2', 'address3', 'city', 'state', 'country'], 'string'],
            [['weight'], 'number'],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
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

    public function getUserparcel()
    {
         return $this->hasOne(UserParcel::className(),['id' => 'parid']);
    }
}
