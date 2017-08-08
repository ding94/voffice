<?php

namespace common\models\Parcel;

use Yii;
use common\models\Parcel\ParcelDetail;
use common\models\Parcel\ParcelOperate;
use common\models\Parcel\ParcelStatus;
use common\models\Parcel\Parcel;
use yii\data\ActiveDataProvider;


class ParcelSearch extends Parcel
{
	public function attributes()
    {
        return array_merge(parent::attributes(),['user.username','user.userdetail.fullname','parceldetail.sender','parceldetail.signer']);
    }

    public function rules()
    {
        return [
            [['user.username' ,'user.userdetail.fullname' ,'type' ,'status' ,'parceldetail.sender' ,'parceldetail.signer'] ,'safe'],
        ];
    }

	public function search($params,$type)
	{
		$query = Parcel::find()->where(['parcel.status' => $type]);

        $query->joinWith(['parceldetail' ,'parceloperate','parcelstatus','user' ,'user.userdetail']);

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
}
