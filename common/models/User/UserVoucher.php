<?php

namespace common\models\user;
use yii\data\ActiveDataProvider;
use Yii;
use common\models\vouchers\{Vouchers,VouchersStatus,VouchersDiscount,VouchersDiscountType,VouchersDiscountItem};
/**
 * This is the model class for table "user_voucher".
 *
 * @property integer $uid
 * @property integer $vid
 * @property string $code
 * @property integer $limitedTime
 */
class UserVoucher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $voucher;   
    public $item;
    public static function tableName()
    {
        return 'user_voucher';
    }

    public function getVouchers()
    {
        return $this->hasOne(Vouchers::className(),['id'=>'vid']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'vid', 'code', 'limitedTime'], 'required'],
            [['uid', 'vid'], 'integer'],
            [['code'], 'string'],
            [['voucher'],'safe'],
            //[['voucher','item'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'vid' => 'Vid',
            'code' => 'Code',
            'limitedTime' => 'Date Expired',
        ];
    }

    public function search($params,$case)
    {
        switch ($case) {
            case 2:
                $query = self::find()->where('uid = :uid',[':uid'=>Yii::$app->user->identity->id]);
                break;
            
            default:
                $query = self::find();
                break;
        }
       
        $query->joinWith(['vouchers']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['voucher'] = [
            'asc' => ['vouchers.discount' => SORT_ASC],
            'desc' => ['vouchers.discount' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['item'] = [
            'asc' => ['vouchers.discount_item' => SORT_ASC],
            'desc' => ['vouchers.discount_item' => SORT_DESC],
        ];

        $this->load($params);

        $query->andFilterWhere(['like','vouchers.discount' , $this->voucher]);
        $query->andFilterWhere(['like','vouchers.discount_item' , $this->item]);

        return $dataProvider;
    }
}
