<?php

namespace App\Http\Controllers;
use App\HomeModel;
use Carbon\Carbon;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	public function __construct() {
		// ----> This part is the keypoint of auth 401 problem;
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('home');
	}

	public function singlePopular() {
		//        $timeTodayStart = Carbon::parse(Carbon::now()->toDateString())->toDateTimeString();
		//        $timeTodayEnd = Carbon::parse((Carbon::now()->toDateString()) . ' 23:59:59')->toDateTimeString();
		$timeTodayStart = '2017-06-16 12:45:33';
		$timeTodayEnd = '2017-06-16 17:08:19';

		$num = ''; // 机器号
		$TodayData = HomeModel::singlePopular($timeTodayStart, $timeTodayEnd, $num);
		return $TodayData;

	}

	public function multiplePopular() {
//        $timeTodayStart = Carbon::parse(Carbon::now()->toDateString())->toDateTimeString();
		//        $timeTodayEnd = Carbon::parse((Carbon::now()->toDateString()) . ' 23:59:59')->toDateTimeString();

		$timeTodayStart = '2017-08-17 00:00:00';
		$timeTodayEnd = '2017-08-17 23:59:59';

		$num = '';

		$TodayData = HomeModel::multiplePopular($timeTodayStart, $timeTodayEnd, $num);
		return $TodayData;
	}

	public function moneyOverView() {
		//        $timeTodayStart = Carbon::parse(Carbon::now()->toDateString())->toDateTimeString();
		//        $timeTodayEnd = Carbon::parse((Carbon::now()->toDateString()) . ' 23:59:59')->toDateTimeString();
		//        $timeLastWeekStart = Carbon::parse(Carbon::now()->subWeek()->toDateString())->toDateTimeString();
		//        $timeLastWeekEnd = Carbon::parse((Carbon::now()->subWeek()->toDateString()) . ' 23:59:59')->toDateTimeString();

		$now = Carbon::now()->getTimestamp();
		$today0Clock = Carbon::today()->getTimestamp();

		$num = '';

		$Data = HomeModel::moneyOverView($today0Clock, $now, $num);
		// $LastWeekData = HomeModel::moneyOverView($timeLastWeekStart, $timeLastWeekEnd, $num);
		// return compact('TodayData', 'LastWeekData');
		return $Data;
	}

	public function payType() {
//        $timeTodayStart = Carbon::parse(Carbon::now()->toDateString())->toDateTimeString();
		//        $timeTodayEnd = Carbon::parse((Carbon::now()->toDateString()) . ' 23:59:59')->toDateTimeString();

		$timeTodayStart = '2017-06-16 12:45:33';
		$timeTodayEnd = '2017-06-16 17:08:19';

		$num = '';

		$TodayData = HomeModel::payType($timeTodayStart, $timeTodayEnd, $num);
		return $TodayData;
	}

	public function WeekFinance() {
//        $timeTodayEnd = Carbon::parse((Carbon::now()->toDateString()) . ' 23:59:59')->toDateTimeString();
		//        $timeLastWeekStart = Carbon::parse(Carbon::now()->subDays(6)->toDateString())->toDateTimeString();

		$num = '';

		$now = Carbon::now()->getTimestamp();
		$startOfWeek = Carbon::create()->startOfWeek()->getTimestamp();

		$TodayData = HomeModel::WeekFinance($startOfWeek, $now, $num);
		return $TodayData;
	}

	public function TodayClient() {
//        $timeTodayStart = Carbon::parse(Carbon::now()->toDateString())->toDateTimeString();
		//        $timeTodayEnd = Carbon::parse((Carbon::now()->toDateString()) . ' 23:59:59')->toDateTimeString();

		$timeTodayStart = '2017-08-17 00:00:00';
		$timeTodayEnd = '2017-08-17 23:59:59';

		$num = '';

		$TodayData = HomeModel::TodayClient($timeTodayStart, $timeTodayEnd, $num);
		return $TodayData;
	}

}
