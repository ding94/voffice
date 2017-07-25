<?php

namespace backend\models;

use yii\base\Model;
use backend\models\Admin;
use yii\data\ActiveDataProvider;

class AdminControl extends Admin 
{
	public $id;
	public $adminname;
	public $email;
	public $status;
	public $adminTittle;

	public function rules()
    {
        return [
            ['adminname', 'trim' ,'on' => ['addAdmin']],
            ['adminname', 'required' , 'on' => ['addAdmin']],
            ['adminname', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This username has already been taken.' , 'on' => ['addAdmin']],
            ['adminname', 'string', 'min' => 2, 'max' => 255 , 'on' => ['addAdmin']],

            ['email', 'trim' , 'on' => ['addAdmin']],
            ['email', 'required' , 'on' => ['addAdmin']],
            ['email', 'email' , 'on' => ['addAdmin']],
            ['email', 'string', 'max' => 255 , 'on' => ['addAdmin']],
            ['email', 'unique', 'targetClass' => '\backend\models\Admin', 'message' => 'This email address has already been taken.' , 'on' => ['addAdmin']],

            ['password', 'required', 'on' => ['addAdmin']],
            ['password', 'string', 'min' => 6 , 'on' => ['addAdmin']],

            ['status' ,'required' , 'on' => ['addAdmin']],
            ['status' , 'in', 'range' => range(1,10) , 'on' => ['addAdmin']],

            ['email'  , 'unique' ,'on' => ['searchAdmin']],
            ['adminname'  ,'safe' ,'on' => ['searchAdmin']],
        ];
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
	public function search($params)
    {
        $query = Admin::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'email' => $this->email,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like','adminname' , $this->adminname]);

        return $dataProvider;
    }

    public function add()
    {
    	if (!$this->validate()) {
            return null;
        }
    	$model = new Admin;
    	$model->adminname = $this->adminname;
    	$model->email = $this->email;
    	$model->status = $this->status;
    	$model->setPassword($this->password);
    	$model->generateAuthKey();
        $model->save();
        
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole('author');
        $auth->assign($authorRole, $model->getId());
        return $model;
    }

}