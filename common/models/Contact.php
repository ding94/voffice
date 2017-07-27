<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property string $username
 * @property string $email
 * @property integer $phone
 * @property string $message
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email','phone', 'message'], 'required'],

			['email', 'email'],
            ['email', 'trim'],

            [['phone'], 'integer'],
            ['phone' ,'match' ,'pattern' => '/^[0-9]{3}[0-9]{7,8}$/i' , 'message' => 'Phone Format is Wrong'],
            [['message'], 'string'],
            [['username', 'email'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'phone' => 'Phone',
            'message' => 'Message',
        ];
    }
	
	public function add($data)
    {
       
        if($this->load($data) && $this->save())
        {
            return true;
        }
        return false;
    }
}
