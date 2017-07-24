<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_parcel".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $received_time
 */
class UserParcel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_parcel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid'], 'integer'],
            [['received_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'received_time' => 'Received Time',
        ];
    }
}
