<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use common\models\OfflineTopup\OfflineTopupStatus;

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
	
	public function attributes()
    {
		return array_merge(parent::attributes(),['offlinetopupstatus.id','offlinetopupstatus.title']);
	}
	
	public function getOfflinetopupstatus()
    {
        return $this->hasOne(OfflineTopupStatus::className(),['id' => 'action']); 
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
		  [['inCharge', 'reason','offlinetopupstatus.title'], 'string'],
		  [['acc_name'],'match', 'pattern' => '/^[a-zA-Z_-\s]*$/i'], 
            [['uid', 'action','to_bank','created_at', 'updated_at','offlinetopupstatus.id'], 'integer'],
            [['withdraw_amount'], 'number','min'=>1],
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
			'action' => 'Status',
			'inCharge' => 'In Charge',
            'reason' => 'Reason',
			'acc_name' => 'Bank Account Name',
            'to_bank' => 'Bank Account',
			'bank_name' => 'Bank Name',
            'from_bank' => 'From Bank',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function search($params,$action)
    {
		
		// $query = UserWithdraw::find();
		 if ($action == 0){
			  $query = self::find(); //自己就是table,找一找资料
		}
		elseif ($action >=1){
			$query= self::find()->where('action = :act',[':act' =>$action]);
		}
		 $query->joinWith(['offlinetopupstatus' ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		 $this->load($params);
		$query->andFilterWhere([
				'title' => $this->getAttribute('offlinetopupstatus.title'),
            ]);
        
       
		  $query->andFilterWhere(['like','acc_name' ,  $this->acc_name])
				->andFilterWhere(['like','withdraw_amount' ,  $this->withdraw_amount])
				->andFilterWhere(['like','to_bank' ,  $this->to_bank])
				->andFilterWhere(['like','bank_name' ,  $this->bank_name])
				->andFilterWhere(['like','inCharge' ,  $this->inCharge])
				->andFilterWhere(['like','reason' ,  $this->reason]);
        //var_dump($query);
        //$query->andFilterWhere(['like','cmpyName' , $this->company]);// 用来查找资料, (['方式','对应资料地方','资料来源'])

        //使用'or'寻找两边column资料
        //$query->andFilterWhere(['or',['like','Fname' , $this->Fname], ['like','Lname' , $this->Fname],]);
 
        return $dataProvider;
    }
}
