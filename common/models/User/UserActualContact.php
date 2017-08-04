<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_actual_contact".
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
class UserActualContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_actual_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'postcode', 'phonenumber'], 'integer'],
            [['address1', 'address2', 'address3', 'state', 'city', 'country'], 'string'],
            [['address1','address2','address3','postcode','state','city','country','phonenumber'],'required','on' => 'mailingAddress'],
            [['phonenumber', 'postcode'], 'integer','on' => 'mailingAddress'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'address3' => 'Address 3',
            'postcode' => 'Postcode',
            'state' => 'State',
            'city' => 'City',
            'country' => 'Country',
            'phonenumber' => 'Phone Number',
        ];
    }

    public function add($data)
    {
        $this->uid = Yii::$app->user->identity->id;
        if($this->load($data) && $this->save())
        {

            return true;
        }
        return false;
    }

    public static function primaryKey()
    {
        return ['uid'];
    }
}
