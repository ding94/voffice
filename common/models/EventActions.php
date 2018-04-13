<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_actions".
 *
 * @property int $id
 * @property int $uid
 * @property int $eid
 * @property int $action
 */
class EventActions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'eid', 'action'], 'required'],
            [['uid', 'eid'], 'integer'],
            [['action'],'string'],
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
            'eid' => 'Eid',
            'action' => 'Action',
        ];
    }
}
