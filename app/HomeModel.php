<?php

namespace App;

use Illuminate\Support\Facades\DB;

class HomeModel {

	// 最受欢迎单品？
	public static function singlePopular($timeStart, $timeEnd, $num) {

		// $result = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
		//  ->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName')
		//  ->select(DB::raw('
		//             COUNT(1) count,
		//             demodishname.dishname dish,
		//             demoorderitem.Name money
		//             '));

		$result = DB::table('demoorder')
			->whereBetween('Date_time', [$timeStart, $timeEnd])
			->where('ClientID', 'like', empty($num) ? '30001%' : ($num . '%'))
			->limit(10)
			->get();
		return $result;

		// ->groupBy('demodishname.PicName')
		// ->orderBy('count', 'desc')
		// ->offset(1)
		// ->take(3)
	}

	public static function multiplePopular($timeStart, $timeEnd, $num) {

		$result = 'multiplePopular';

		// $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
		//  ->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName')
		//  ->select(DB::raw('
		//                   demoorder.ClientID clientid,
		//                   demoorder.ID id,
		//                   GROUP_CONCAT( demodishname.dishname, \'*\', Number order by demodishname.dishname ) combine,
		//                   demoorder.Total_money money
		//                   '))
		//  ->whereBetween('Date_time', [$timeStart, $timeEnd])
		//  ->groupBy('id');

		// if (empty($num)) {
		//  $sub = $sub->where('demoorder.ClientID', 'like', '30001%');
		// } else {
		//  $sub = $sub->where('demoorder.ClientID', 'like', $num . '%');
		// }

		// $result = DB::table(DB::raw("({$sub->toSql()}) as sub"))
		//  ->mergeBindings($sub->getQuery()) // 非常重要 文档里没有提
		//  ->select(DB::raw('
		//                       sub.combine,
		//                       count(*) count,
		//                       sub.money
		//                       '
		//  ))
		//  ->groupBy('sub.combine')
		//  ->orderBy('count', 'desc')
		//  ->limit(3);

		return $result;
	}

	public static function moneyOverView($timeStart, $timeEnd, $num) {

		$result = 'moneyOverView';

		if (empty($timeStart) || empty($timeEnd) || ($timeEnd < $timeStart)) {
			return [
				'error' => 'wrong time',
			];
		}

		// $result = DB::table('demoorder')
		// 	->whereBetween('');

		// $result = DB::table('demoorder')->select(DB::raw('
		//                   DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
		//                   COUNT(1) count,
		//                   SUM(Total_money) money'));

		// if (empty($num)) {
		// 	$result = $result->where('ClientID', 'like', '30001%');
		// } else {
		// 	$result = $result->where('ClientID', 'like', $num . '%');
		// }

		// $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

		// $result = $result
		// 	->get();

		return $result;
	}

	public static function payType($timeStart, $timeEnd, $num) {

		$result = 'payType';

//        OrderModel::where('Pay_type', '=', 'W')
		//            ->update(['Pay_type' => 'K']);

		// if (empty($timeStart) || empty($timeEnd) || ($timeEnd < $timeStart)) {
		// 	return [
		// 		'error' => 'wrong time',
		// 	];
		// }

		// $result = DB::table('demoorder')->select(DB::raw('
		//                   COUNT(1) count,
		//                   Pay_type payType'));

		// if (empty($num)) {
		// 	$result = $result->where('ClientID', 'like', '30001%');
		// } else {
		// 	$result = $result->where('ClientID', 'like', $num . '%');
		// }

		// $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

		// $result = $result
		// 	->groupBy('payType')
		// 	->get();

		return $result;
	}

	public static function WeekFinance($timeStart, $timeEnd, $num) {
		$result = 'WeekFinance';
		// if (empty($timeStart) || empty($timeEnd) || ($timeEnd < $timeStart)) {
		// 	return [
		// 		'error' => 'wrong time',
		// 	];
		// }

		// $result = DB::table('demoorder')->select(DB::raw('
		//                   DATE_FORMAT(Date_time,\'%m-%d\') date,
		//                   SUM(Total_money) money'));

		// if (empty($num)) {
		// 	$result = $result->where('ClientID', 'like', '30001%');
		// } else {
		// 	$result = $result->where('ClientID', 'like', $num . '%');
		// }

		// $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

		// $result = $result
		// 	->orderBy('date', 'desc')
		// 	->groupBy('date')
		// 	->get();

		return $result;
	}

	public static function TodayClient($timeStart, $timeEnd, $num) {
		$result = 'TodayClient';
		// if (empty($timeStart) || empty($timeEnd) || ($timeEnd < $timeStart)) {
		// 	return [
		// 		'error' => 'wrong time',
		// 	];
		// }

		// $result = DB::table('demoorder')->select(DB::raw('
		//                   CONCAT(DATE_FORMAT(Date_time, \'%H:\' ),
		//                   FLOOR(DATE_FORMAT(Date_time, \'%i\' ) /10 ),\'0\') date,
		//                   COUNT(1) count'));

		// if (empty($num)) {
		// 	$result = $result->where('ClientID', 'like', '30001%');
		// } else {
		// 	$result = $result->where('ClientID', 'like', $num . '%');
		// }

		// $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

		// $result = $result
		// 	->orderBy('date', 'desc')
		// 	->groupBy('date')
		// 	->get();

		return $result;
	}

}
