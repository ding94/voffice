<?php
namespace common\models\user;

use Yii;
use common\models\User\User;
use common\models\User\UserDeatils;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{

    public function attributes()
    {
        return array_merge(parent::attributes(),['userdetails.fullname']);
    }

    public function rules()
    {
        return [
            ['email' , 'unique'],
            [['username' ,'userdetails.fullname' ,'status'] ,'safe'],
        ];
    }


    public function search($params)
    {
        $query = User::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['userdetails.fullname'] = [
            'asc'=>['Fname'=>SORT_ASC, 'Lname'=>SORT_ASC],
            'desc'=>['Fname'=>SORT_ASC, 'Lname'=>SORT_ASC],
        ];

        $query->joinWith(['userdetails']);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,

        ]);

        $query->andFilterWhere(['like','username' , $this->username]);
        $query->andFilterWhere(['like','email' , $this->email]);
        $query->andWhere('Fname LIKE "%' . $this->getAttribute('userdetails.fullname') . '%" ' . //This will filter when only first name is searched.
            'OR Lname LIKE "%' .  $this->getAttribute('userdetails.fullname') . '%" '. //This will filter when only last name is searched.
            'OR CONCAT(Fname, " ", Lname) LIKE "%' . $this->getAttribute('userdetails.fullname') . '%"' //This will filter when full name is searched.
        );
       
        return $dataProvider;
    }
}