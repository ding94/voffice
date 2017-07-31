<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parcel".
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
class Parcel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parcel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parid', 'sender', 'signer', 'signer_ic', 'weight', 'size'], 'required'],
            [['parid', 'postcode'], 'integer'],
            [['sender', 'signer', 'signer_ic', 'address1', 'address2', 'address3', 'city', 'state', 'country', 'size'], 'string'],
            [['weight'], 'number'],
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
            'signer_ic' => 'Signer Ic',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'address3' => 'Address3',
            'postcode' => 'Postcode',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'weight' => 'Weight',
            'size' => 'Size',
        ];
    }
}
