<?php

namespace App\Http\Controllers;

use App\CheckModel;
use App\DataModel;
use App\OrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class FinanceController extends Controller
{
    public function orderNum(Request $request)
    {
        $timeStart = Carbon::parse($request -> input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request -> input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        
        $device = $request->input('device');
        
        $orderNum = OrderModel::orderNum($timeStart, $timeEnd, $device);
        return $orderNum;
    }
    
    public function turnover(Request $request)
    {
        $timeStart = Carbon::parse($request -> input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request -> input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $device = $request->input('device');
        
        $turnOver = OrderModel::turnover($timeStart, $timeEnd, $device);
        return $turnOver;
    }
    
    
    public function turnoverDetail(Request $request)
    {
        $timeStart = Carbon::parse($request -> input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request -> input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        
        $device = $request->input('device');
        $turnover = OrderModel::turnoverDetail($timeStart, $timeEnd, $device);
        return $turnover;
    }
    
    
    public function oderMoneyDistribute(Request $request)
    {
        $timeStart = Carbon::parse($request -> input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request -> input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        
        $device = $request->input('device');
        $oderMoneyDistribute = OrderModel::oderMoneyDistribute($timeStart, $timeEnd, $device);
        return $oderMoneyDistribute;
    }
    
    
    public function payType(Request $request)
    {
        $timeStart = Carbon::parse($request -> input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request -> input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        
        $device = $request->input('device');
        $oderMoneyDistribute = OrderModel::payType($timeStart, $timeEnd, $device);
        return $oderMoneyDistribute;
    }
    
    
    
    
    //
    public function finance(Request $request)
    {
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
    
    
}