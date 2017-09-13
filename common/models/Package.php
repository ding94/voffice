<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "package".
 *
 * @property integer $id
 * @property double $price
 * @property string $type
 */
class Package extends \yii\db\ActiveRecord
{
    public $packageTitle;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['price', 'type','rank'], 'required'],
			[['price'], 'number'],
            [['type'], 'string'],
			[['rank'],'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'type' => 'Title',
			'rank' => 'Rank',
        ];
    }

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like','type' , $this->type]);

        return $dataProvider;
    }

    public static function getAmountList($package_type)
    {
        $amount = self::find()
            ->select(['id','price'])
            ->where(['id' => $package_type])
			 ->where(['id' => $package_price])
            ->asArray()
            ->all();

        //$testamount = ArrayHelper::map(self::find()->where(['id' => $package_type])->all(),'price','id');

        return $amount;
    }
}
