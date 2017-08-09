<?php

namespace backend\modules\logistics\controllers;

use Yii;
use yii\web\Controller;
use common\models\Parcel\ParcelDetail;

Class ParcelDetailController extends Controller
{
	public static function createDetail($parid,$post)
	{
		$detail = new ParcelDetail;
		$detail->load($post);
		$detail->parid = $parid;
		return $detail;
	}
}