<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscribe_type".
 *
 * @property integer $id
 * @property string $description
 */
class SubscribeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribe_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description','sub_period','next_payment'], 'string'],
            ['times' ,'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Subscribe Description',
        ];
    }
}
