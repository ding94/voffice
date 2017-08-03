<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_company".
 *
 * @property string $cmpyName
 * @property string $cmpyRegisNo
 * @property integer $uid
 * @property string $cmpyType
 * @property string $industry
 * @property string $picture
 */
class UserCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cmpyName', 'cmpyRegisNo', 'uid', 'cmpyType', 'industry'], 'required'],
            [['cmpyName', 'cmpyRegisNo', 'cmpyType', 'industry', 'picture'], 'string'],
            [['uid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cmpyName' => 'Cmpy Name',
            'cmpyRegisNo' => 'Cmpy Regis No',
            'uid' => 'Uid',
            'cmpyType' => 'Cmpy Type',
            'industry' => 'Industry',
            'picture' => 'Picture',
        ];
    }
}
