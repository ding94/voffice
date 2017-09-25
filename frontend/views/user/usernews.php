<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div style="padding-top: 100px; width: 300px; min-height: 100vh; float: left;">
	<ul>
	<?php foreach ($model as $k => $n) { ?>
		<li>
		<?= Html::a('<span>'.$n['name'].'</span>', Url::toRoute(['user/news', 'id' => $n['id']]), ['class' => 'profile-link']) ?>
		<span class="pull-right"><?php echo $n['startTime']; ?></span>
		</li>
	<?php } ?>
	</ul>
</div>
<div class="container" style="padding-top: 50px;">
	<div class="row">
		<div class="h1" style="border-bottom: 1px solid;">
			<?php echo $news['name']; ?>
		</div>
		<?php echo $news['text']; ?>
	</div>
</div>