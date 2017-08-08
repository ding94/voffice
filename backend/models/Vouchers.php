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
            [['code', 'discount', 'inCharge','startDate','endDate','amount','digit'], 'required'],
            [['code', 'inCharge', 'status'], 'string'],
            ['code', 'unique', 'targetClass' => '\backend\models\Vouchers', 'message' => 'These digits codes has already been used.' , 'on' => ['changeAdmin']],
            [ 'usedTimes', 'integer'],
            ['digit', 'integer','min'=> 5,'max'=> 100],
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
            'discount' => 'Discount',
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
        //$query->andFilterWhere(['like','cmpyName' , $this->company]);// 用来查找资料, (['方式','对应资料地方','资料来源'])

        //使用'or'寻找两边column资料
        //$query->andFilterWhere(['or',['like','Fname' , $this->Fname], ['like','Lname' , $this->Fname],]);
 
        return $dataProvider;
    }
}
