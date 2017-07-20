<?php

namespace backend\models;

use yii\base\Model;
use backend\models\Admin;
use yii\data\ActiveDataProvider;

class AdminControl extends Model
{
	public $id;
	public $adminname;
	public $email;
	public $status;

	public function rules()
    {
        return [
            [['adminname', 'email' ,'status'], 'safe'],
        ];
    }

	public function search($params)
    {
        $query = Admin::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'adminname' => $this->adminname,
            'email' => $this->email,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like','adminname' , $this->adminname]);

        return $dataProvider;
    }
}