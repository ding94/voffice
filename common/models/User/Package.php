<?php

namespace common\models\User;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property integer $id
 * @property string $type
 * @property string $price
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'price'], 'required'],
            [['type'], 'string'],
            [['price'], 'number'],
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
            'price' => 'Price',
        ];
    }
}
