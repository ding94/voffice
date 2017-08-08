<?php

namespace common\models\Parcel;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\Parcel\Parcel;

/**
 * This is the model class for table "parcel_operate".
 *
 * @property integer $id
 * @property integer $parid
 * @property string $adminname
 * @property integer $oldVal
 * @property integer $newVal
 * @property integer $update_at
 */
class ParcelOperate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parcel_operate';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],   
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parid', 'adminname', 'newVal'], 'required'],
            [['parid','created_at', 'updated_at'], 'integer'],
            [['adminname','oldVal', 'newVal'], 'string', 'max' => 20],
            [['parid'] ,'exist' ,
              'skipOnError' => true,
              'targetClass' => Parcel::className(),
              'targetAttribute' => ['parid' => 'id']]
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
            'adminname' => 'Adminname',
            'oldVal' => 'Old Val',
            'newVal' => 'New Val',
            'updated_at' => 'Update At',
        ];
    }

    public function getParcel()
    {
        return $this->hasOne(Parcel::className(),['id' => 'parid']);
    }
}
