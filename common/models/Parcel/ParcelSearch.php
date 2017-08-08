<?php

namespace common\models\Parcel;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\Parcel;
use yii\data\ActiveDataProvider;

class ParcelSearch extends Parcel
{
    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(),['parceldetail.sender','parceldetail.signer','parceldetail.address1','parceldetail.address2','parceldetail.address3','parceldetail.postcode','parceldetail.city','parceldetail.state','parceldetail.country','parceldetail.weight']);
    }

    public function rules()
    {
        return [
            [['uid', 'status', 'updated_at','created_at' ,'type'], 'integer'],
            [['parceldetail.sender','parceldetail.signer','parceldetail.address1','parceldetail.address2','parceldetail.address3','parceldetail.postcode','parceldetail.city','parceldetail.state','parceldetail.country'],'string'],
            [['parceldetail.weight'],'number'],
            [['id','uid','type','status','sender','signer','address1','address2','address3','postcode','city','state','country','weight'],'safe'],
        ];
    }

    public function search($params)
    {
        $query = Parcel::find()->where('uid = :uid' ,[':uid' => Yii::$app->user->identity->id]);
        $query->joinWith(['parceldetail']);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->load($params);
        $query->andFilterWhere(['like','sender' , $this->getAttribute('parceldetail.sender')])
              ->andFilterWhere(['like','signer' , $this->getAttribute('parceldetail.signer')])
              ->andFilterWhere(['like','address1' , $this->getAttribute('parceldetail.address1')])
              ->andFilterWhere(['like','address2' , $this->getAttribute('parceldetail.address2')])
              ->andFilterWhere(['like','address3' , $this->getAttribute('parceldetail.address3')])
              ->andFilterWhere(['like','postcode' , $this->getAttribute('parceldetail.postcode')])
              ->andFilterWhere(['like','city' , $this->getAttribute('parceldetail.city')])
              ->andFilterWhere(['like','state' , $this->getAttribute('parceldetail.state')])
              ->andFilterWhere(['like','country' , $this->getAttribute('parceldetail.country')])
              ->andFilterWhere(['like','weight' , $this->getAttribute('parceldetail.weight')]);

        
        return $dataProvider;
    }
}
