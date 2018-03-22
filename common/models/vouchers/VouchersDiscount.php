<?php

namespace common\models\vouchers;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * This is the model class for table "vouchers_discount".
 *
 * @property integer $id
 * @property string $description
 */
class VouchersDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vouchers_discount';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(),['vouchers.status']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid','discount','discount_type','discount_item'], 'required'],
            [['vid','discount_type','discount_item'], 'integer'],
            ['discount','integer','min'=> 1],

            [['vouchers.status'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vid' => 'Voucher ID',
            'discount' => 'Discount Amount',
            'discount_type' => 'Discount Type',
            'discount_item' => 'Discount Item',
        ];
    }

    public function search($params,$case)
    {
        switch ($case) {
            case 2:
                $query = self::find()->andWhere(['=','vouchers.status',5]);
                break;
            
            default:
                $query = self::find()->andWhere(['!=','vouchers.status',5]);
                break;
        }
        
        $query->joinWith(['voucher']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);

        $query->andFilterWhere(['vid' => $this->vid]);
        $query->andFilterWhere(['like','vouchers_discount.discount_item' , $this->discount_item]);
        //var_dump($this['voucher.status']);exit;
        $query->andFilterWhere(['like','vouchers.status' , $this['vouchers.status']]);
        $query->andFilterWhere(['like','vouchers_discount.discount_type' , $this->discount_type]);
        $query->andFilterWhere(['like','vouchers_discount.discount_item' , $this->discount_item]);
 
        return $dataProvider;
    }

    public function getVoucher(){
        return $this->hasOne(Vouchers::className(),['id'=>'vid']);
    }
}
