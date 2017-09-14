<?php 
namespace common\components;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use common\models\Notification;
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
		$model = new Notification;
		$model->uid =1;
		$model->content = "Add new record on".Yii::$app->controller->id;
		$model->save();
	}
}
