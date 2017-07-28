<?php

namespace backend\models\auth;

use Yii;
use backend\models\auth\AuthItem;
use backend\models\auth\AuthItemChild;
use yii\data\ActiveDataProvider;

class AuthControl extends \yii\db\ActiveRecord
{
	public $name;
	public $description;
	public $created_at;
	public $updated_at;

	public function rules()
	{
		return [
			[['name','description'] ,'safe'],
		];
	}

	public function search($params)
	{
		$query = AuthItem::find()->where(['type' => 1]);
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        return $dataProvider;
	}
}
