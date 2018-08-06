<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodName extends Model {
	//
	protected $table = 'demofoodname';
	public $timestamps = false;

	public static function foodInfo($timeStart, $timeEnd, $device, $food) {
		$checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
		if ($checkTime !== 0) {
			return $checkTime;
		}
	}
}
