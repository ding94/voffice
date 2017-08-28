<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "user_withdraw".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $withdraw_amount
 * @property string $to_bank
 * @property string $from_bank
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserWithdraw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_withdraw';
    }
	
	public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],   
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'withdraw_amount', 'to_bank', 'acc_name'], 'required'],
		  [['acc_name'], 'string'],
            [['uid', 'to_bank','created_at', 'updated_at'], 'integer'],
            [['withdraw_amount'], 'number'],
            [[ 'bank_name','from_bank'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'withdraw_amount' => 'Withdraw Amount (RM)',
			'acc_name' => 'Account Name',
            'to_bank' => 'Bank Account',
			'bank_name' => 'Bank Name',
            'from_bank' => 'From Bank',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function search($params)
    {
		
		 $query = UserWithdraw::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        $this->load($params);

        //var_dump($query);
        //$query->andFilterWhere(['like','cmpyName' , $this->company]);// 用来查找资料, (['方式','对应资料地方','资料来源'])

        //使用'or'寻找两边column资料
        //$query->andFilterWhere(['or',['like','Fname' , $this->Fname], ['like','Lname' , $this->Fname],]);
 
        return $dataProvider;
    }
}
