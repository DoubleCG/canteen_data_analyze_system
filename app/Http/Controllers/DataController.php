<?php

namespace App\Http\Controllers;

use App\CheckModel;
use App\DataModel;
use App\Exports\UsersExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller {

	public function export() {
		return Excel::download(new UsersExport, 'users.xlsx');
	}

	public function news() {
		return DataModel::news();

		// function array_utf8_encode($dat) {
		// 	if (is_string($dat)) {
		// 		return utf8_encode($dat);
		// 	}

		// 	if (!is_array($dat)) {
		// 		return $dat;
		// 	}

		// 	$ret = array();
		// 	foreach ($dat as $i => $d) {
		// 		$ret[$i] = array_utf8_encode($d);
		// 	}

		// 	return $ret;
		// }
		// $result = Redis::set('a', array_utf8_encode('123'));
	}

	//
	public function finance(Request $request) {
		$timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
		$timeEnd = Carbon::parse(($request->input('timeEnd')) . ' 23:59:59')->toDateTimeString();
		$type = $request->input('type');
		$num = $request->input('num');

		if (empty($timeStart) || empty($timeEnd) || ($timeEnd <= $timeStart)) {
			return [
				'error' => 'wrong time',
			];
		}
		if (empty($type)) {
			return [
				'error' => 'wrong type',
			];
		}
		$result = DataModel::finance($timeStart, $timeEnd, $type, $num);
		return $result;
	}

	public function orderDetial(Request $request) {
		$perPage = 20;
		$page = $request->input("page", 1) - 1;
		$timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
		$timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

		$checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
		if ($checkTime !== 0) {
			return $checkTime;
		}
		$num = $request->input('num');

		$result = DataModel::orderDetial($timeStart, $timeEnd, $num);

		$total = $result->count();

		$items = $result
			->skip($page * $perPage)
			->take($perPage)
			->get();

		$paged = new LengthAwarePaginator($items, $total, $perPage);
		return $paged;
	}

	public function orderCheck(Request $request) {
		$orderid = $request->input('orderid');
		$timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
		$timeEnd = Carbon::parse(($request->input('timeEnd')) . ' 23:59:59')->toDateTimeString();
		$num = $request->input('num');

		if (empty($timeStart) || empty($timeEnd) || ($timeEnd <= $timeStart)) {
			return [
				'error' => 'wrong time',
			];
		}

		if (!empty($orderid) && !is_numeric($orderid)) {
			return [
				'error' => 'wrong time',
			];
		}
		$param = compact('orderid', 'timeStart', 'timeEnd', 'num');

		$result = DataModel::orderCheck($param);

		return $result;
	}

	public function allDishSales(Request $request) {
		$time = Carbon::parse($request->input('time'))->toDateString();
		$num = $request->input('num');

		if (empty($time)) {
			return [
				'error' => 'error time',
			];
		}

		$result = DataModel::allDishSales($time, $num);

		return $result;
	}

	public function dishSales(Request $request) {

		$time = Carbon::parse($request->input('time'))->toDateString();
		$dish = $request->input('dish');
		$num = $request->input('num');
		if (empty($dish)) {
			return [
				'error' => 'error dish',
			];
		}

		if (empty($time)) {
			return [
				'error' => 'error time',
			];
		}

		$result = DataModel::dishSales($time, $num, $dish);

		return $result;

	}

	public function dishName() {
		return DataModel::dishName();
	}

	public function popular(Request $request) {
		$timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
		$timeEnd = Carbon::parse(($request->input('timeEnd')) . ' 23:59:59')->toDateTimeString();
		$type = $request->input('type');
		$num = $request->input('num');

		if (empty($timeStart) || empty($timeEnd) || ($timeEnd <= $timeStart)) {
			return [
				'error' => 'wrong time',
			];
		}

		if (empty($type)) {
			return [
				'error' => 'wrong type',
			];
		}

		$param = compact('timeStart', 'timeEnd', 'type', 'num');

		$result = DataModel::popular($param);

		return $result;

	}
}
