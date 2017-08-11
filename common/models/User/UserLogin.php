<?php

namespace common\models\User;

use yii\base\Model;
use common\models\User\User;
use yii\data\ActiveDataProvider;
use Yii;

class UserLogin extends Model 
{
	public $old_password;
    public $new_password;
    public $repeat_password;
    public $_user;

	public function rules()
    {
        return [
            [['old_password', 'new_password', 'repeat_password'], 'required'],
            [['old_password'], 'validatePasswords'],
            [['repeat_password'], 'compare', 'compareAttribute'=>'new_password'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
	public function findPasswords($attribute, $params)
    {
        if (!$this->validatePassword($this->old_password)){
            $this->addError($attribute, 'Old password is incorrect.');
        }
    }

    public function validatePasswords($attribute, $params)
     {
      if (!$this->hasErrors()) {

        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->old_password)) {

            $this->addError($attribute, 'Incorrect username or password.');
         }
        
        }
       }


    public function check()
    {
    	if (!$this->validate()) {
            return null;
        }
       
    	$model = User::find()->where('id = :id' ,[':id' => Yii::$app->user->identity->id])->one();
    	$model->setPassword($this->new_password);
    	$model->generateAuthKey();
       
        $model->save();
        return $model;
    }

    protected function getUser()
      {
        if ($this->_user === null) {
          $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        }

        return $this->_user;
        }


}