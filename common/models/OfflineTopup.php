<?php

namespace common\models;
 use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "offline_topup".
 *
 * @property integer $id
 * @property string $username
 * @property string $amount
 * @property string $description
 * @property string $action
 * @property string $inCharge
 * @property string $rejectReason
 * @property string $picture
 */
class OfflineTopup extends \yii\db\ActiveRecord
{
	public $picture;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offline_topup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'username','amount'], 'safe'],
           [['username','description', 'action', 'inCharge', 'rejectReason'], 'string'],
           [['amount'], 'number'],
		  
			
        ];
		    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'amount' => 'Amount',
            'description' => 'Description',
            'action' => 'Action',
            'inCharge' => 'In Charge',
            'rejectReason' => 'Reject Reason',
            'picture' => 'Picture',
        ];
    }
	public function add($data)
    {
       //$this->createtime = time();
	  
        if($this->load($data) && $this->save())
        {
			
            return true;
        }
        return false;
    }
	
	public function upload()
    {
		//var_dump ($this); exit;
        if ($this->validate()) {
            $this->picture->saveAs('img/topup/' . $this->picture->baseName . '.' . $this->picture->extension);
		//var_dump ($this); exit;
            return true;
        } else {
            return false;
        }
}
}
