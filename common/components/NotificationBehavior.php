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
			$model = new Notification;
			$model->uid = Yii::$app->user->identity->id;
			$model->role = $available->role;
			$model->content = $available->description.' '.Yii::$app->user->identity->username;
			$model->save();
		}
	}
}
