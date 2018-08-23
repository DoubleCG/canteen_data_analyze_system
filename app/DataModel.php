<?php

namespace App;

use Illuminate\Support\Facades\DB;

class DataModel {

	public static function news() {
		$result = DB::table('news')->get();
		DB::table('news')->delete();
		return json_encode($result);
	}

	public static function finance($timeStart, $timeEnd, $type, $num) {

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

		switch ($type) {
		case 'year':
			$result = DB::table('demoorder')->select(DB::raw('
                    ClientID clientid,
                    YEAR(Date_time) year,
                    DATE_FORMAT(Date_time,\'%Y\') date,
                    COUNT(1) count,
                    SUM(Total_money) money'));
			break;
		case 'month':
			$result = DB::table('demoorder')->select(DB::raw('
                    ClientID clientid,
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DATE_FORMAT(Date_time,\'%Y-%m\') date,
                    COUNT(1) count,
                    SUM(Total_money) money'));
			break;
		case 'week':
			$result = DB::table('demoorder')->select(DB::raw('
                    ClientID clientid,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    DATE_FORMAT(Date_time,\'%u\') week,
                    COUNT(1) count,
                    SUM(Total_money) money'));
			break;

		case 'day':
			$result = DB::table('demoorder')->select(DB::raw('
                    ClientID clientid,
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    COUNT(1) count,
                    SUM(Total_money) money'));
			break;

		default:
			return [
				'error' => 'wrong type',
			];
		}

		if (empty($num)) {
			$result = $result->where('ClientID', 'like', '30001%');
		} else {
			$result = $result->where('ClientID', 'like', $num . '%');
		}

		$result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

		switch ($type) {
		case 'year':
			$result = $result
				->orderBy('year', 'asc')
				->groupBy('year')
				->get();
			break;
		case 'month':
			$result = $result
				->orderBy('year', 'asc')
				->orderBy('month', 'asc')
				->groupBy('year', 'month')
				->get();
			break;
		case 'week':
			$result = $result
				->orderBy('week', 'asc')
				->groupBy('week')
				->get();
			break;

		case 'day':
			$result = $result
				->orderBy('year', 'asc')
				->orderBy('month', 'asc')
				->orderBy('day', 'asc')
				->groupBy('year', 'month', 'day')
				->groupBy('ClientID')
				->get();
			break;

		default:
			return [
				'error' => 'wrong type',
			];
		}

		return $result->groupBy('date');
	}

	public static function orderDetial($timeStart, $timeEnd, $num) {

		if (empty($timeStart) || empty($timeEnd) || ($timeEnd <= $timeStart)) {
			return [
				'error' => 'wrong time',
			];
		}

		$result = DB::table('demoorder')
			->select(DB::raw('
                    OrderID orderid,
                    ClientID clientid,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    DATE_FORMAT(Date_time,\'%H:%i:%s\') time,
                    Total_money money,
                    dishname item,
                    Name price,
                    Number count,
                    Pay_type pay'))
			->join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
			->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName');

		if (empty($num)) {
			$result = $result->where('clientid', 'like', '30001%');
		} else {
			$result = $result->where('clientid', 'like', $num . '%');
		}

		$result = $result
			->whereBetween('Date_time', [$timeStart, $timeEnd])
			->orderBy('orderid', 'desc');

		return $result;
	}

	public static function orderCheck(array $param = []) {
		$orderid = $param['orderid'];
		$timeStart = $param['timeStart'];
		$timeEnd = $param['timeEnd'];
		$num = $param['num'];

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

		$data1 = DB::table('demoorder')->select(DB::raw('
            ID id,
            ClientID clientid,
            Order_number orderid,
            Date_time date,
            Total_money money
        '))->whereBetween('Date_time', [$timeStart, $timeEnd]);

		$data2 = DB::table('demoorderitem')->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName')
			->join('demoorder', 'demoorderitem.OrderID', '=', 'demoorder.ID')
			->select(DB::raw('
                OrderID id,
                Name price,
                Number count,
                dishname
            '))
			->whereBetween('demoorder.Date_time', [$timeStart, $timeEnd]);

		if (!empty($orderid)) {
			$data1 = $data1->where('demoorder.id', 'like', '%' . $orderid . '%');
			$data2 = $data2->where('demoorder.id', 'like', '%' . $orderid . '%');
		}

		if (empty($num)) {
			$data1 = $data1->where('demoorder.ClientID', 'like', '30001%');
			$data2 = $data2->where('demoorder.ClientID', 'like', '30001%');
		} else {
			$data1 = $data1->where('demoorder.ClientID', 'like', $num . '%');
			$data2 = $data2->where('demoorder.ClientID', 'like', $num . '%');
		}

		$data1 = $data1->get();
		$data2 = $data2->get()->groupBy('id');

		return [
			'data1' => $data1,
			'data2' => $data2,
		];
	}

	public static function dishSales($time, $num, $dish) {

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

		$result = DB::table('demodishname')->where('dishname', '=', $dish)
			->join('demoorderitem', 'demodishname.PicName', '=', 'demoorderitem.PicName')
			->join('demoorder', 'demoorderitem.OrderID', '=', 'demoorder.ID')
			->whereDate('Date_time', $time)
			->select(DB::raw('
            CONCAT(DATE_FORMAT(Date_time, \'%Y-%m-%d %H:\' ),
            FLOOR(DATE_FORMAT(Date_time, \'%i\' ) /10 ),\'0\') time,
            ClientID clientid,
            COUNT(*) count
            '))
			->groupBy('time');

		if (empty($num)) {
			$result = $result->where('demoorder.ClientID', 'like', '30001%');
		} else {
			$result = $result->where('demoorder.ClientID', 'like', $num . '%');

		}

		return $result->get();
	}

	public static function allDishSales($time, $num) {

		if (empty($time)) {
			return [
				'error' => 'error time',
			];
		}

		$result = DB::table('demodishname')
			->join('demoorderitem', 'demodishname.PicName', '=', 'demoorderitem.PicName')
			->join('demoorder', 'demoorderitem.OrderID', '=', 'demoorder.ID')
			->select(DB::raw('
            demodishname.dishname dishname,
            COUNT(*) count
            '))
			->groupBy('dishname')
			->orderBy('count', 'desc');

		if (empty($num)) {
			$result = $result->where('demoorder.ClientID', 'like', '30001%');
		} else {
			$result = $result->where('demoorder.ClientID', 'like', $num . '%');

		}

		return $result->get();
	}

	public static function dishName() {
		return DB::table('demodishname')->select(DB::raw('
            dishname value,
            dishname label
        '))->get();
	}

	public static function popular(array $param = []) {

		$timeStart = $param['timeStart'];
		$timeEnd = $param['timeEnd'];
		$type = $param['type'];
		$num = $param['num'];

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

		switch ($type) {
		case 'price':{
				$sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
					->select(DB::raw('
                    demoorder.ClientID clientid,
                    demoorder.ID id,
                    GROUP_CONCAT( Name, \'*\', Number order by name ) combine
                    '))
					->whereBetween('Date_time', [$timeStart, $timeEnd])
					->groupBy('id');

				if (empty($num)) {
					$sub = $sub->where('demoorder.ClientID', 'like', '30001%');
				} else {
					$sub = $sub->where('demoorder.ClientID', 'like', $num . '%');
				}
				break;
			}

		case 'plate':{
				$sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
					->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName')
					->select(DB::raw('
                    demoorder.ClientID clientid,
                    demoorder.ID id,
                    GROUP_CONCAT( demodishname.dishname, \'*\', Number order by demodishname.dishname ) combine
                    '))
					->whereBetween('Date_time', [$timeStart, $timeEnd])
					->groupBy('id');

				if (empty($num)) {
					$sub = $sub->where('demoorder.ClientID', 'like', '30001%');
				} else {
					$sub = $sub->where('demoorder.ClientID', 'like', $num . '%');
				}

				break;
			}
		}
		$result = DB::table(DB::raw("({$sub->toSql()}) as sub"))
			->mergeBindings($sub->getQuery()) // 非常重要 文档里没有提
			->select(DB::raw('
                        sub.combine,
                        count(*) count
                        '
			))
			->groupBy('sub.combine')
			->orderBy('count', 'desc');

		return $result->get();

	}

}
