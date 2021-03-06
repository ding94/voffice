<?php

namespace common\models\vouchers;
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
            [['id','startDate'],'safe'],
            [['code','inCharge'], 'required'],
            [['amount','digit'],'required', 'on' => ['generate']], // 'on' = 判断senario
            //[['discount'],'required', 'on' => ['generate','add']],
            [['code'], 'string'],
            //['code', 'unique', 'targetClass' => '\backend\models\Vouchers', 'message' => 'These digits codes has already been used.'],
            [['usedTimes','status','discount_type','discount_item', 'inCharge'], 'integer'],
            [['endDate','status'],'safe'],
            ['digit', 'integer','min'=> 8,'max'=> 20],
            ['amount','integer','min'=> 1,'max'=> 100],
            //['discount','integer','min'=> 1],

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
            'discount' => 'Discount',
            'discount_type' => 'Discount Type',
            'discount_item' => 'Discount Item',
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
        $query->andFilterWhere(['like','discount_type' , $this->discount_type]);
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
        $query = self::find()->where(['or',['status'=>1],['status'=>4]]); //自己就是table,找一找资料
        //$query = self::find()->where(['or',['status'=>1],['status'=>4]]);
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

    public function getDiscount(){
        return $this->hasMany(VouchersDiscount::className(),['vid'=>'id']);
    }
}
