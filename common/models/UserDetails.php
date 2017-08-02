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
            [['gender', 'address1', 'address2', 'address3', 'city', 'state', 'country','picture'], 'string'],
            [['DOB'], 'safe'],
            [['DOB'], 'date', 'format' => 'yyyy-mm-dd' ,'message' => 'Format as YYYY-MM-DD'],
            [['Fname', 'Lname'], 'string', 'max' => 50],
            [['IC_passport'], 'string', 'max' => 30],
            [['fullname'] , 'safe'], // 设置 fullname的 searchbox
            [['postcode'],'string', 'max' => 5,'min' => 5],
            [['Fname','Lname','gender','IC_passport','address1','address2','address3','city','state','country'],'default','value' => ''],
            [['phonenumber','postcode'],'default','value' => '0'],
            [['DOB'],'default','value' => '2000-01-01'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            // 这里改label的名字
            'uid' => 'Uid',
            'Fname' => 'Full Name',
            'Lname' => 'Last Name',
            'gender' => 'Gender',
            'DOB' => 'Date of Birth',
            'IC_passport' => 'IC or Passport',
            'phonenumber' => 'Phone Number',
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'address3' => 'Address 3',
            'postcode' => 'Postcode',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            //'fullname' => '', 
        ];
    }

    public function search($params)
    {
        $query = self::find(); //自己就是table,找一找资料
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        $this->load($params);

        //$name = UserDetails::find()->one();
        //$FullName = $name->Fname.' '.$name->Lname; 
        //var_dump($fullName);exit;
        //$query->andFilterWhere(['like','cmpyname' , $this->cmpyname]);// 用来查找资料

        //使用'or'寻找两边column资料
        $query->andFilterWhere(['or',
                                ['like','Fname' , $this->Fname],
                                ['like','Lname' , $this->Fname],
                            ]);
 
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
