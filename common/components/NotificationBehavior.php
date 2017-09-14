<?php 
namespace common\components;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use common\models\Notification\Notification;
use common\models\Notification\NotificationSetting;
use Yii;

class NotificationBehavior extends Behavior
{
	public function events()
	{
		return[
			ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
      		ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
		];
	}

	public function afterInsert($event)
	{
		$namespace = Yii::$app->controller->module->controllerNamespace;
		$controller = Yii::$app->controller->id;
	    $action = Yii::$app->controller->action->id;
	    $permissionName = $controller.'/'.$action;
	    $available = NotificationSetting::find()->where('type = :t and name =:n',[':t' => $namespace , ':n' => $permissionName])->one();

		if($available)
		{
			$auth = \Yii::$app->authManager;
    		$role = $auth->getUserIdsByRole($available->role);
    		$superadmin =  $auth->getUserIdsByRole('super admin');
    		$mergeRole = array_merge($role,$superadmin);

    		foreach($mergeRole as $adminid)
    		{
    			$model = new Notification;
				$model->adminid = $adminid;
				$model->content = $available->description.' '.Yii::$app->user->identity->username;
				$model->save();
    		}
			
		}
	}
}
