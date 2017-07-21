<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_contact".
 *
 * @property integer $uid
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property integer $postcode
 * @property string $state
 * @property string $city
 * @property string $country
 * @property integer $phonenumber
 */
class UserContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'address1', 'address2', 'address3', 'postcode', 'state', 'city', 'country', 'phonenumber'], 'required'],
            [['uid', 'postcode', 'phonenumber'], 'integer'],
            [['address1', 'address2', 'address3', 'state', 'city', 'country'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'address3' => 'Address3',
            'postcode' => 'Postcode',
            'state' => 'State',
            'city' => 'City',
            'country' => 'Country',
            'phonenumber' => 'Phonenumber',
        ];
    }
}
