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
        return array_merge(parent::attributes(),['userdetail.fullname','usercompany.cmpyName']);
    }

    public function rules()
    {
        return [
            ['email' , 'unique'],
            [['username' ,'userdetail.fullname' ,'usercompany.cmpyName' ,'status' ] ,'safe'],
        ];
    }


    public function search($params)
    {
        $query = User::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['userdetail.fullname'] = [
            'asc'=>['Fname'=>SORT_ASC, 'Lname'=>SORT_ASC],
            'desc'=>['Fname'=>SORT_DESC, 'Lname'=>SORT_DESC],
        ];

        $dataProvider->sort->attributes['usercompany.cmpyName'] = [
            'asc'=>['cmpyName'=>SORT_ASC],
            'desc'=>['cmpyName'=>SORT_DESC],
        ];

        $query->joinWith(['userdetail','usercompany']);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,

        ]);

        $query->andFilterWhere(['like','username' , $this->username]);
        $query->andFilterWhere(['like','cmpyName' , $this->getAttribute('usercompany.cmpyName')]);
        $query->andFilterWhere(['like','email' , $this->email]);
       $query->andFilterWhere(['or',
                                    ['like','Fname',$this->getAttribute('userdetail.fullname')],
                                    ['like','Lname',$this->getAttribute('userdetail.fullname')],
                                    ['like', 'concat(Fname, " " , Lname) ', $this->getAttribute('userdetail.fullname')]
                               ]);
        

        /*$query->andWhere('Fname LIKE "%' . $this->getAttribute('userdetail.fullname') . '%" ' . //This will filter when only first name is searched.
            'OR Lname LIKE "%' .  $this->getAttribute('userdetail.fullname') . '%" '. //This will filter when only last name is searched.
            'OR CONCAT(Fname, " ", Lname) LIKE "%' . $this->getAttribute('userdetail.fullname') . '%"' //This will filter when full name is searched.
        );
       */
        return $dataProvider;
    }
}