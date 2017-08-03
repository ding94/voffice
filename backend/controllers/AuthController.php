<?php 

namespace backend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\models\auth\AuthItem;
use backend\models\auth\AuthItemChild;
use Yii;

Class AuthController extends Controller
{

	public function actionIndex()
	{
		$searchModel = new AuthItem();
		$dataProvider = $searchModel-> search(Yii::$app->request->queryParams , 1);

		return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}

	public function actionView($id)
	{
		$model = new AuthItemChild();

		$auth = \Yii::$app->authManager;
		
		$available = $auth->getChildren($id);
		
		$notAvailable =  self::notAvailableSotring($available);
		
		$listAvailabe =  ArrayHelper::map($available,'name' ,'name');
		$listAll =  ArrayHelper::map($notAvailable,'name' ,'name');
		
		return $this->render('view' ,['model' => $model ,'listAvailabe' => $listAvailabe , 'listAll' => $listAll ,'id' => $id]);
	}

	public function actionRemoveRole($id)
	{
		$allchild= Yii::$app->request->post('AuthItemChild');

		$data = $this->modifyRole($id,$allchild['child'],2);
		if($data == true)
		{
			Yii::$app->session->setFlash('warning', "Delete Completed");
		}
		else
		{
			Yii::$app->session->setFlash('Danger', "Fail Delete");
		}
		
	    return $this->redirect(['view' ,'id' => $id]);
	}

	public function actionAddRole($id)
	{
		$allchild= Yii::$app->request->post('AuthItemChild');

		$data = $this->modifyRole($id,$allchild['child'],1);
		if($data == true)
		{
			Yii::$app->session->setFlash('success', "Add Completed");
		}
		else
		{
			Yii::$app->session->setFlash('Danger', "Fail Added");
		}
		
	    return $this->redirect(['view' ,'id' => $id]);
	}

	protected function modifyRole($id,$childData,$type)
	{
		$auth = \Yii::$app->authManager;
		$parent = $auth->getRole($id);
		
		$data ="";
		foreach ($childData as $key => $value) 
		{
			$child = $auth->getPermission($value);

			switch ($type) {
				case 1:
					if($auth->canAddChild($parent,$child))
					{
						$auth->addChild($parent,$child);
						$data = true;
					}
					$data = false;
					break;
				case 2:
					$auth->removeChild($parent,$child);
					$data = true;
					break;
				default:
					$data = false;
					break;
			}
		}
		return $data;
	}

	public function actionAdd()
	{
		$list = [[ 'type' => 1 , 'name' => 'Role Name' ],[ 'type' => 2 , 'name' => 'Permission link']];
		$listOfType = ArrayHelper::map($list, 'type', 'name');
		$model = new AuthItem();
		if($model->load(Yii::$app->request->post()))
		{
			$isValid = $model->validate();
			if($isValid)
			{
				$data = Yii::$app->request->post('AuthItem');
				$message = self::roleOrPermission($data);
				if($message == true)
				{
					Yii::$app->session->setFlash('success', "Add completed");
	    			return $this->redirect(['index']);
				}
				else
				{
					Yii::$app->session->setFlash('warning', "Fail added");
	    			return $this->redirect(['index']);
				}
			}
		}
		return $this->render('add' ,['model' => $model ,'listOfType' => $listOfType]);
	}

	/*
	 * remove avaiable child in auth item
	 */
	public static function notAvailableSotring($available)
	{
		$auth = \Yii::$app->authManager;
		$data = $auth->getPermissions();
		//$data =  AuthItem::find()->where(['type' => 2])->all();
		
		/*foreach ($available as $k => $value) 
		{
			foreach ($data as $i => $not) {
				if($not['name'] == $value['name'])
				{
					 unset($data[$i]);
				}
			}
		}*/
		$data = array_diff_key($data,$available);
		
		return $data;
	}

	/*
	 * based on which permission 
	 */
	public static function roleOrPermission($data)
	{
		$auth = \Yii::$app->authManager;

		if((int)$data['type'] === 2)
		{
			$create = $auth->createPermission($data['name']);
			$create->description   = $data['description'];
		
		}
		elseif((int)$data['type'] === 1)
		{
			$create = $auth->createRole($data['name']);
			$create->description = $data['description'];
		}
		else
		{
			return false;
		}

		if($auth->add($create))
		{
			return true;
		}
		
		return false;
	}

	protected function findModel($id)
    {
        if (($model = AuthItemChild::findAll($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findAuth($id)
    {
    	if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } 

}