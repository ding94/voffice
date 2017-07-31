<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_details".
 *
 * @property integer $uid
 * @property string $Fname
 * @property string $Lname
 * @property string $gender
 * @property string $DOB
 * @property string $cmpyname
 * @property string $cmpycategory
 * @property string $IC/passport
 * @property integer $phonenumber
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property integer $postcode
 * @property string $city
 * @property string $state
 * @property string $country
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'phonenumber', 'postcode'], 'integer'],
            [['gender', 'cmpyname', 'cmpycategory', 'address1', 'address2', 'address3', 'city', 'state', 'country'], 'string'],
            [['DOB'], 'safe'],
            [['DOB'], 'date', 'format' => 'yyyy-mm-dd' ,'message' => 'Format as YYYY-MM-DD'],
            [['Fname', 'Lname'], 'string', 'max' => 50],
            [['IC_passport'], 'string', 'max' => 30],
            [['postcode'],'string', 'max' => 5,'min' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'Fname' => 'First Name',
            'Lname' => 'Last Name',
            'gender' => 'Gender',
            'DOB' => 'Date of Birth',
            'cmpyname' => 'Company Name',
            'cmpycategory' => 'Company Category',
            'IC_passport' => 'IC or Passport',
            'phonenumber' => 'Phone Number',
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'address3' => 'Address 3',
            'postcode' => 'Postcode',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
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
