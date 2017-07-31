<?php

namespace common\models;
use yii\data\ActiveDataProvider;
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
    public $fullname;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_details';
    }

    public function getFullname() {
        return $this->Fname . ' ' . $this->Lname;
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
            [['fullname'] , 'safe'], // 设置 fullname的 searchbox
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
            'fullname' => 'Full Name', // 这里改label的名字
        ];
    }

    public function search($params)
    {
        $query = self::find(); //自己就是table,找一找资料
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
            'fullname' => [
                'asc' => ['Fname' => SORT_ASC, 'Lname' => SORT_ASC],
                'desc' => ['Fname' => SORT_DESC, 'Lname' => SORT_DESC],
                
                'default' => SORT_ASC,
            ],
        ]
        ]);
        $this->load($params);

        //$name = UserDetails::find()->one();
        //$FullName = $name->Fname.' '.$name->Lname; 
        //var_dump($fullName);exit;
        $query->andFilterWhere(['like','cmpyname' , $this->cmpyname]);// 用来查找资料
        $query->andWhere('Fname LIKE "%' . $this->fullname . '%" ' . //This will filter when only first name is searched.
        'OR Lname LIKE "%' . $this->fullname . '%" '. //This will filter when only last name is searched.
        'OR CONCAT(Fname, " ", Lname) LIKE "%' . $this->fullname . '%"'); //This will filter when full name is searched.
  
        //$query->andFilterWhere(['like','Lname' , $this->Lname]);
        
        
        return $dataProvider;
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
