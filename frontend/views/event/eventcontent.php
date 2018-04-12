<?php
use yii\helpers\Html;
use yii\helpers\Url;
// use frontend\assets\NewsAsset;

// NewsAsset::register($this);
?>
<style>
	@import url('https://fonts.googleapis.com/css?family=Montserrat|Roboto+Slab');

	#event-container{
		font-family: "Roboto Slab", "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 18px;
	}

	#event-container p{
		font-size: 16px;
	}
</style>
<div id="event-container">
	<div id="eventContent" title="Event Details">
<!-- 		<h2>echo $model['title']; </h2> -->
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title">Start & End Time</h3>
		  </div>
		  <ul class="list-group">
		    <li class="list-group-item">Start: <?php echo date('Y-m-d g:i:s A', strtotime($model['start'])); ?></li>
		    <li class="list-group-item">End: <?php echo date('Y-m-d g:i:s A', strtotime($model['end'])); ?></li>
		  </ul>
		</div>
	   <!--  Start: echo date('Y-m-d g:i:s A', strtotime($model['start'])); <br>
	    End:  echo date('Y-m-d g:i:s A', strtotime($model['end'])); <br><br> -->
	    <div class="panel panel-success">
		  <div class="panel-heading">
		    <h3 class="panel-title">Details</h3>
		  </div>
		  <div class="panel-body">
		    <p id="eventInfo"><?php echo $model['details']; ?></p>
		  </div>
		</div>
	    <!-- <p><strong><a id="eventLink" href="" target="_blank">Read More</a></strong></p> -->
	    <div class="btn-group btn-group-justified" role="group">
		  <div class="btn-group" role="group">
		  	<?php if($actionstatus['action'] == 'Going'){ 
		  		echo Html::a('You are Going', ['event/going','id'=>$model['id']], ['id' => 'going-btn','class' => 'btn btn-success disabled']); 
		  	} else {
		  		echo Html::a('Going', ['event/going','id'=>$model['id']], ['id' => 'going-btn','class' => 'btn btn-success']);
		  	}
		  	?>
		  </div>
		  <div class="btn-group" role="group">
		  	<?php if($actionstatus['action'] == 'Decline'){ 
		  		echo Html::a('You have Declined', ['event/decline','id'=>$model['id']], ['id' => 'decline-btn','class' => 'btn btn-danger disabled']); 
		  	} else {
		  		echo Html::a('Decline', ['event/decline','id'=>$model['id']], ['id' => 'decline-btn','class' => 'btn btn-danger']);
		  	}
		  	?>
		  </div>
		  <div class="btn-group" role="group">
		  	<?php if($actionstatus['action'] == 'Ignore'){ 
		  		echo Html::a('You have Ignored', ['event/ignore','id'=>$model['id']], ['id' => 'ignore-btn','class' => 'btn btn-default disabled']); 
		  	} else {
		  		echo Html::a('Ignore', ['event/ignore','id'=>$model['id']], ['id' => 'ignore-btn','class' => 'btn btn-default']);
		  	}
		  	?>
		  </div>
		</div>
	</div>
</div>