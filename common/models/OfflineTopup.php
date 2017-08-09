<?php

namespace common\models;
use yii\data\ActiveDataProvider;
use Yii;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'amount', 'picture'], 'required'],
            [['username', 'description', 'action', 'inCharge', 'rejectReason'], 'string'],
            [['amount'], 'number','min'=>10],
            [['picture'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'amount' => 'Amount',
            'description' => 'Description',
            'action' => 'Action',
            'inCharge' => 'In Charge',
            'rejectReason' => 'Reject Reason',
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
	}
      
        
        //$query->joinWith(['company']);

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
