<?php

namespace backend\models;

use yii\base\Model;
use common\models\SubscribePackageHistory;
use yii\data\ActiveDataProvider;

class SubscribeHistorySearch extends SubscribePackageHistory
{
	public function attributes()
    {
        return array_merge(parent::attributes(),['user.username','package.type','subscribeType.description']);
    }

	public function rules()
	{
		return[
			[['id','amount','user.username' ,'package.type' ,'subscribeType.description'],'safe'],
		];
	}

	public function search($params)
	{
		$query = SubscribePackageHistory::find();

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['user','package','subscribeType']);

        $this->load($params);


        $dataProvider->sort->attributes['user.username'] = [
            'asc'=>['username'=>SORT_ASC],
            'desc'=>['username'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['package.type'] = [
            'asc'=>['type'=>SORT_ASC],
            'desc'=>['type'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['subscribeType.description'] = [
            'asc'=>['description'=>SORT_ASC],
            'desc'=>['description'=>SORT_DESC],
        ];

        return $dataProvider;
	}
}