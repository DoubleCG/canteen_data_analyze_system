<?php

namespace App\Http\Controllers;

use App\CheckModel;
use App\DataModel;
use App\DishName;
use App\FoodName;
use App\OrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class ClientController extends Controller
{
    public function trafficDetail(Request $request)
    {
        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        $device = $request->input('device');

        $traffic = OrderModel::trafficDetail($timeStart, $timeEnd, $device);
        return $traffic;
    }


    public function avClient(Request $request)
    {
        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        $device = $request->input('device');

        $avClient = OrderModel::avClient($timeStart, $timeEnd, $device);
        return $avClient;

    }


}