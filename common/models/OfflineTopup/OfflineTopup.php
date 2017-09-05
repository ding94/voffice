<?php

namespace common\models\OfflineTopup;
use yii\data\ActiveDataProvider;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "offline_topup".
 *
 * @property integer $id
 * @property string $username
 * @property string $amount
 * @property string $description
 * @property string $action
 * @property string $inCharge
 * @property string $rejectReason
 * @property string $picture
 */
class OfflineTopup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_topup';
    }
	
	public function attributes()
    {
		return array_merge(parent::attributes(),['offlinetopupstatus.id','offlinetopupstatus.title','offlinetopupstatus.labelName']);
	}
	
	public function getOfflinetopupstatus()
    {
        return $this->hasOne(OfflineTopupStatus::className(),['id' => 'action']); 
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'amount', 'picture'], 'required'],
            [['username', 'description', 'inCharge', 'rejectReason','offlinetopupstatus.title'], 'string'],
			[['action','action_before','offlinetopupstatus.id'],'integer'],
            [['amount'], 'number','min'=>10],
            [['picture'], 'string', 'max' => 100],
			[['bank_name'], 'string', 'max' => 255],
		
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           
		    
		    'id'=> 'ID',
		    'username' => 'Username',
            'amount' => 'Amount',
            'description' => 'Description',
			'bank_name' => 'Bank Name',
            'action' => 'Action',
            'inCharge' => 'In Charge',
            'rejectReason' => 'Reason',
            'picture' => 'Picture',
        ];
    }
	
	public function search($params,$action)
    {
		
		if ($action == 0){
			  $query = self::find(); //自己就是table,找一找资料
		}
		elseif ($action >=1){
			$query= self::find()->where('action = :act',[':act' =>$action]);
			
			//$query = OfflineTopupStatus::find()->where(['offlinetopupstatus.description' => $action]);

		}
		$query->joinWith(['offlinetopupstatus' ]);
        //$query->joinWith(['company']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
		
		   $query->andFilterWhere([
				'title' => $this->getAttribute('offlinetopupstatus.title'),
				//'id' =>   $this->id,
            ]);
			
		  $query 
				->andFilterWhere(['like','username' ,  $this->username])
				->andFilterWhere(['like','amount' ,  $this->amount])
				->andFilterWhere(['like','description' ,  $this->description])
				->andFilterWhere(['like','bank_name' ,  $this->bank_name])
				->andFilterWhere(['like','inCharge' ,  $this->inCharge])
				->andFilterWhere(['like','rejectReason' ,  $this->rejectReason]);
				
			
        //var_dump($query);
        //$query->andFilterWhere(['like','cmpyName' , $this->company]);// 用来查找资料, (['方式','对应资料地方','资料来源'])

        //使用'or'寻找两边column资料
        //$query->andFilterWhere(['or',['like','Fname' , $this->Fname], ['like','Lname' , $this->Fname],]);
 
        return $dataProvider;
    }
	
	 
}
