<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Events;
use common\models\EventActions;

class EventController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$data = Events::find()->all();
    	$eventsArray=ArrayHelper::toArray($data);
    	foreach ($eventsArray as $key => $value) {
    		$Event = new \yii2fullcalendar\models\Event();
    		$Event->id = $value['id'];
    		$Event->title = $value['title'];
    		$Event->start = $value['start'];
    		$Event->end = $value['end'];
    		$Event->nonstandard = $value['details'];
    		$events[] = $Event;
    	}

	  // //Testing
	  // $Event = new \yii2fullcalendar\models\Event();
	  // // var_dump($Event);exit;
	  // $Event->id = 1;
	  // $Event->title = 'Testing';
	  // $Event->start = '2018-04-02 09:14:00';
	  // $Event->end = '2018-04-05 08:54:25';
	  // $Event->nonstandard = [
	  //   'field1' => 'Something I want to be included in object #1',
	  //   'field2' => 'Something I want to be included in object #2',
	  // ];
	  // $events[] = $Event;

	  // $Event = new \yii2fullcalendar\models\Event();
	  // $Event->id = 2;
	  // $Event->title = 'Second Testing';
	  // $Event->start = '2018-04-06 08:54:00';
	  // $Event->end = '2018-04-07 08:54:25';
	  // $events[] = $Event;

        return $this->render('index',['events' => $events]);
    }

    public function actionGoing($id)
    {
    	$model = EventActions::find()->where('eid=:eid',[':eid'=>(int)$id])->andWhere('uid=:uid',[':uid'=>Yii::$app->user->identity->id])->one();
    	if(empty($model)){
    		$model = new EventActions;
    		$model->uid = Yii::$app->user->identity->id;
    		$model->eid = (int)$id;
    		$model->action = 'Going';
    		if($model->validate()){
    			$model->save();
    			Yii::$app->getSession()->setFlash('info','You have accepted the event invitation!');
    			return $this->redirect(['/event/index']);
    		}
    	} else {
    		$model->action = 'Going';
    		if($model->validate()){
    			$model->save();
    			Yii::$app->getSession()->setFlash('info','You have accepted the event invitation!');
    			return $this->redirect(['/event/index']);
    		}
    	}
    }

    public function actionDecline($id)
    {
    	$model = EventActions::find()->where('eid=:eid',[':eid'=>(int)$id])->andWhere('uid=:uid',[':uid'=>Yii::$app->user->identity->id])->one();
    	if(empty($model)){
    		$model = new EventActions;
    		$model->uid = Yii::$app->user->identity->id;
    		$model->eid = (int)$id;
    		$model->action = 'Decline';
    		if($model->validate()){
    			$model->save();
    			Yii::$app->getSession()->setFlash('danger','You have declined the event invitation!');
    			return $this->redirect(['/event/index']);
    		}
    	} else {
    		$model->action = 'Decline';
    		if($model->validate()){
    			$model->save();
    			Yii::$app->getSession()->setFlash('danger','You have declined the event invitation!');
    			return $this->redirect(['/event/index']);
    		}
    	}
    }

    public function actionIgnore($id)
    {
    	$model = EventActions::find()->where('eid=:eid',[':eid'=>(int)$id])->andWhere('uid=:uid',[':uid'=>Yii::$app->user->identity->id])->one();
    	if(empty($model)){
    		$model = new EventActions;
    		$model->uid = Yii::$app->user->identity->id;
    		$model->eid = (int)$id;
    		$model->action = 'Ignore';
    		if($model->validate()){
    			$model->save();
    			Yii::$app->getSession()->setFlash('warning','You have ignored the event invitation!');
    			return $this->redirect(['/event/index']);
    		}
    	} else {
    		$model->action = 'Ignore';
    		if($model->validate()){
    			$model->save();
    			Yii::$app->getSession()->setFlash('warning','You have ignored the event invitation!');
    			return $this->redirect(['/event/index']);
    		}
    	}
    }

    public function actionEventContent($id)
    {
    	$model = Events::find()->where('id=:id',[':id'=>$id])->one();
    	$actionstatus = EventActions::find()->where('eid=:eid',[':eid'=>$id])->andWhere('uid=:uid',[':uid'=>Yii::$app->user->identity->id])->one();
    	return $this->renderPartial('eventcontent',['model'=>$model,'actionstatus'=>$actionstatus]);
    }
}
