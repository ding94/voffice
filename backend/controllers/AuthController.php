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

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams , 1);
		
		return $this->render('index',['model' => $dataProvider , 'searchModel' => $searchModel]);
	}

	public function actionPermission()
	{
		$searchModel = new AuthItem();
	
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams ,2);
		
		return $this->render('permission' , ['model' => $dataProvider , 'searchModel' => $searchModel]);
	}

	public function actionView($id)
	{
		$model = new AuthItemChild();

		$auth = \Yii::$app->authManager;

		$verify = $auth->getPermission($id);

		if($verify)
		{
			Yii::$app->session->setFlash('warning', 'Not In Role List');
			return $this->redirect(Yii::$app->request->referrer);
		}

		$available = $auth->getChildren($id);
		
		$notAvailable =  self::notAvailableSotring($available);
		
		$listAvailabe =  ArrayHelper::map($available,'name' ,'name');
		$listAll =  ArrayHelper::map($notAvailable,'name' ,'name');
		
		return $this->render('view' ,['model' => $model ,'listAvailabe' => $listAvailabe , 'listAll' => $listAll ,'id' => $id]);
	}

	public function actionDelete($id)
	{
		$auth = \Yii::$app->authManager;

		$data = $auth->getPermission($id);

		if(empty($data))
		{
			$data = $auth->getRole($id);
		}

		if($auth->remove($data))
		{
			Yii::$app->session->setFlash('success', "Delete Completed");
		}
		else
		{
			Yii::$app->session->setFlash('warning', "Fail Delete");
		}
		
		return $this->redirect(['index']);
	}

	public function actionRemoveRole($id)
	{
		$allchild= Yii::$app->request->post('AuthItemChild');

		$data = $this->modifyRole($id,$allchild['child'],2);
		if($data == true)
		{
			Yii::$app->session->setFlash('success', "Delete Completed");
		}
		else
		{
			Yii::$app->session->setFlash('warning', "Fail Delete");
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
			Yii::$app->session->setFlash('warning', "Fail Added");
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
					else
					{
						$data = false;
					}
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
			$create->data = $data['data'];
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
}