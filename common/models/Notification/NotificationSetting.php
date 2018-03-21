<?php

namespace common\models\Notification;

use Yii;

/**
 * This is the model class for table "notification_setting".
 *
 * @property integer $id
 * @property string $type
 * @property string $role
 * @property string $name
 * @property string $description
 * @property integer $created_at
 */
class NotificationSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'role', 'name', 'description','icon', 'created_at'], 'required'],
            [['description','icon'], 'string'],
            [['created_at'], 'integer'],
            [['type', 'role'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'role' => 'Role',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }
}
