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
        return array_merge(parent::attributes(),['userdetails.fullname','usercompany.cmpyName']);
    }

    public function rules()
    {
        return [
            ['email' , 'unique'],
            [['username' ,'userdetails.fullname' ,'usercompany.cmpyName' ,'status' ] ,'safe'],
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
            'desc'=>['Fname'=>SORT_DESC, 'Lname'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['usercompany.cmpyName'] = [
            'asc'=>['cmpyName'=>SORT_ASC],
            'desc'=>['cmpyName'=>SORT_DESC],
        ];

        $query->joinWith(['userdetails']);
        $query->joinWith(['usercompany']);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,

        ]);

        $query->andFilterWhere(['like','username' , $this->username]);
        $query->andFilterWhere(['like','cmpyName' , $this->getAttribute('usercompany.cmpyName')]);
        $query->andFilterWhere(['like','email' , $this->email]);

        $query->andWhere('Fname LIKE "%' . $this->getAttribute('userdetails.fullname') . '%" ' . //This will filter when only first name is searched.
            'OR Lname LIKE "%' .  $this->getAttribute('userdetails.fullname') . '%" '. //This will filter when only last name is searched.
            'OR CONCAT(Fname, " ", Lname) LIKE "%' . $this->getAttribute('userdetails.fullname') . '%"' //This will filter when full name is searched.
        );
       
        return $dataProvider;
    }
}