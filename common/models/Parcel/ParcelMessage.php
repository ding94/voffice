<?php

namespace common\models\Parcel;

use Yii;

/**
 * This is the model class for table "parcel_message".
 *
 * @property integer $id
 * @property integer $parid
 * @property string $message
 * @property integer $adminname
 * @property string $userRead
 * @property string $adminRead
 * @property integer $created_at
 */
class ParcelMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parcel_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parid', 'message', 'adminname', 'userRead', 'adminRead', 'created_at'], 'required'],
            [['parid', 'adminname', 'created_at'], 'integer'],
            [['message', 'userRead', 'adminRead'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parid' => 'Parid',
            'message' => 'Message',
            'adminname' => 'Adminname',
            'userRead' => 'User Read',
            'adminRead' => 'Admin Read',
            'created_at' => 'Created At',
        ];
    }
}
