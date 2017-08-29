<?php

namespace backend\models;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * This is the model class for table "vouchers".
 *
 * @property integer $id
 * @property string $code
 * @property integer $discount
 * @property integer $status
 * @property integer $usedTimes
 * @property string $inCharge
 */
class Vouchers extends \yii\db\ActiveRecord
{
    public $amount;
    public $digit;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vouchers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id','safe'],
            [['code','inCharge','startDate'], 'required'],
            [['amount','digit'],'required', 'on' => ['generate']], // 'on' = 判断senario, 为了给controller 知道放哪里 
            [['discount'],'required', 'on' => ['generate','add']],
            [['code', 'inCharge'], 'string'],
            ['code', 'unique', 'targetClass' => '\backend\models\Vouchers', 'message' => 'These digits codes has already been used.'],
            [ ['usedTimes','status'], 'integer'],
            ['digit', 'integer','min'=> 8,'max'=> 20],
            ['amount','integer','min'=> 2,'max'=> 100],
            ['discount','integer','min'=>5,'max'=>100],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'discount' => 'Discount %',
            'status' => 'Status', 
            'usedTimes' => 'Used Times',
            'inCharge' => 'In Charge',
        ];
    }

    public function search($params)
    {
        $query = self::find(); //自己就是table,找一找资料
        
        //$query->joinWith(['company']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        $this->load($params);

        //var_dump($query);
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like','code' , $this->code]);
        $query->andFilterWhere(['like','discount' , $this->discount]);
        $query->andFilterWhere(['like','status' , $this->status]);
        $query->andFilterWhere(['like','usedTimes' , $this->usedTimes]);
        $query->andFilterWhere(['like','inCharge' , $this->inCharge]);
        $query->andFilterWhere(['like','startDate' , $this->startDate]);
        $query->andFilterWhere(['like','endDate' , $this->endDate]);

        //使用'or'寻找两边column资料
        //$query->andFilterWhere(['or',['like','Fname' , $this->Fname], ['like','Lname' , $this->Fname],]);
 
        return $dataProvider;
    }

    public function searchvalid($params)
    {
        $query = self::find()->where('status = :s', [':s' => 0]); //自己就是table,找一找资料
        
        //$query->joinWith(['company']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        $this->load($params);

        //var_dump($query);
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like','code' , $this->code]);
        $query->andFilterWhere(['like','discount' , $this->discount]);
        $query->andFilterWhere(['like','status' , $this->status]);
        $query->andFilterWhere(['like','usedTimes' , $this->usedTimes]);
        $query->andFilterWhere(['like','inCharge' , $this->inCharge]);
        $query->andFilterWhere(['like','startDate' , $this->startDate]);
        $query->andFilterWhere(['like','endDate' , $this->endDate]);

        //使用'or'寻找两边column资料
        //$query->andFilterWhere(['or',['like','Fname' , $this->Fname], ['like','Lname' , $this->Fname],]);
        
        return $dataProvider;
    }
}
