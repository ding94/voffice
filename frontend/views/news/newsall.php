<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
?>


<div class="container" id="news-container">
	<div class="row">
		<h2>All News</h2>
		<?= 
		ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_newsall',
			'itemOptions' => [
				'tag' => 'li',
			],
			'options' => [
				'tag' => 'ul',
			],
			'layout' => "{items}\n{pager}",
			'pager' => [
        'firstPageLabel' => 'first',
        'lastPageLabel' => 'last',
        'nextPageLabel' => 'next',
        'prevPageLabel' => 'previous',
        'maxButtonCount' => 3,
    ],
		]); 
		?>
	</div>
</div>