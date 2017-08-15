<?php

namespace common\models\Parcel;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\ParcelOperate;
use common\models\Parcel\ParcelStatus;
use common\models\Parcel\ParcelStatusName;
use common\models\Parcel\Parcel;
use yii\data\ActiveDataProvider;

class ParcelSearch extends Parcel
{

	public $titlename ="";

    public function attributes()

    {
        return array_merge(parent::attributes(),['parceldetail.sender','parceldetail.signer','parceldetail.address1','parceldetail.address2','parceldetail.address3','parceldetail.postcode','parceldetail.city','parceldetail.state','parceldetail.country','parceldetail.weight','user.username','user.userdetail.fullname','parcelstatusname.description','parcelstatusname.id']);
    }

    public function rules()
    {
        return [
            [['uid', 'status', 'updated_at','created_at' ,'type','parcelstatusname.id'], 'integer'],
            [['parceldetail.sender','parceldetail.signer','parceldetail.address1','parceldetail.address2','parceldetail.address3','parceldetail.postcode','parceldetail.city','parceldetail.state','parceldetail.country','parcelstatusname.description'],'string'],
            [['parceldetail.weight'],'number'],
            [['user.username' ,'user.userdetail.fullname' ,'id','uid','type','status','sender','signer','address1','address2','address3','postcode','city','state','country','weight','parcelstatusname.description','parcelstatusname.id'],'safe'],
        ];
    }

	public function search($params,$type)
	{
		$query = Parcel::find()->where(['parcel.status' => $type]);

        $query->joinWith(['parceldetail' ,'parcelstatus','user' ,'user.userdetail']);

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user.username'] = [
            'asc'=>['Fname'=>SORT_ASC, 'Lname'=>SORT_ASC],
            'desc'=>['Fname'=>SORT_DESC, 'Lname'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['user.userdetail.fullname'] = [
            'asc'=>['username'=>SORT_ASC],
            'desc'=>['username'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['parceldetail.sender'] = [
             'asc'=>['sender'=>SORT_ASC],
            'desc'=>['sender'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['parceldetail.signer'] = [
             'asc'=>['signer'=>SORT_ASC],
            'desc'=>['signer'=>SORT_DESC],
        ];

		if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->load($params);

        $query->andFilterWhere([
            'status' => $this->status,
            'type' => $this->type,
        ]);


        $query->andFilterWhere(['like','username' , $this->getAttribute('user.username')]);
        $query->andFilterWhere(['like','sender' , $this->getAttribute('parceldetail.sender')]);
        $query->andFilterWhere(['like','signer' , $this->getAttribute('parceldetail.signer')]);
    
        $query->andWhere('Fname LIKE "%' . $this->getAttribute('user.userdetail.fullname') . '%" ' . 
            'OR Lname LIKE "%' .   $this->getAttribute('user.userdetail.fullname') . '%" '.
            'OR CONCAT(Fname, " ", Lname) LIKE "%' .  $this->getAttribute('user.userdetail.fullname') . '%"'
        );

        return $dataProvider;
    }

    public function searchparceldetail($params,$uid)
    {
        $query = Parcel::find()->where('uid = :uid' ,[':uid' =>$uid ]);
        $query->joinWith(['parceldetail','parcelstatusname']);
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['parcelstatusname.description'] = [
            'asc'=>['description'=>SORT_ASC],
            'desc'=>['description'=>SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->load($params);

        $query->andFilterWhere([
            'type' => $this->type,
            'status' => $this->status,
            'description' => $this->getAttribute('parcelstatusname.description'),
            ]);

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
