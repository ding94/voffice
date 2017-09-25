<?php

namespace common\models\User;

use Yii;
use common\models\Package;
use common\models\User\UserPackageSubscription;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_package".
 *
 * @property integer $uid
 * @property integer $packid
 * @property string $code
 * @property string $subscribe_time
 * @property string $end_period
 * @property integer $sub_period
 */
class UserPackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_package';
    }

    /**
     * @inheritdoc
     */
	 public function getUserpackagesubscription()
    {
        return $this->hasOne(UserPackageSubscription::className(),['uid' => 'uid']); 
    }
    public function rules()
    {
        return [
            [['uid', 'packid', 'subscribe_time', 'end_period', 'sub_period'], 'required'],
            [['uid', 'packid', 'sub_period','type'], 'integer'],
            [['code'], 'string'],
            [['subscribe_time', 'end_period','sub_period'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'UID',
            'packid' => 'Package',
            'code' => 'Code',
			'type'=> 'Subscription Type',
            'subscribe_time' => 'Subscribe Time',
            'end_period' => 'End Period',
            'sub_period' => 'Sub Period',
        ];
    }

    public static function primaryKey()
    {
        return ['uid'];
    }

    public function getPackage()
    {
        return $this->hasOne(Package::classname(),['id' => 'packid']);
    }
	
	public function search($params)
    {
		
		
			  $query = self::find(); //自己就是table,找一找资料
			  $query->joinWith(['userpackagesubscription' ]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
		 
		    $query 
				->andFilterWhere(['like','uid' ,  $this->uid])
				->andFilterWhere(['like','packid' ,  $this->packid])
				->andFilterWhere(['like','code' ,  $this->code])
				->andFilterWhere(['like','type' ,  $this->type])
				->andFilterWhere(['like','subscribe_time' ,$this->subscribe_time])
				->andFilterWhere(['like',self::tableName().'.end_period' ,  $this->end_period])
				->andFilterWhere(['like','sub_period' ,  $this->sub_period]);
				//->andFilterWhere(['like', '	userpackagesubscription.next_payment' ,$this->	userpackagesubscription.next_payment]);
 
        return $dataProvider;
    }
}


