<?php

namespace App\Http\Controllers;

use App\CheckModel;
use App\DataModel;
use App\DishName;
use App\ExcelModel;
use App\FoodName;
use App\OrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class SalesController extends Controller
{
    public function popularPackage(Request $request)
    {
        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $device = $request->input('device');

        $popular = OrderModel::popularPackage($timeStart, $timeEnd, $device);
        return $popular;
    }

    public function popularFood(Request $request)
    {
        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }


        $device = $request->input('device');

        $popular = OrderModel::popularFood($timeStart, $timeEnd, $device);
        return $popular;
    }

    public function foodInfo(Request $request)
    {

        $food = $request->input('food');

        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);


        if ($checkTime !== 0) {
            return $checkTime;
        }

        $checkFood = CheckModel::checkFood($food);

        if ($checkFood !== 0) {
            return $checkFood;
        }


        $device = $request->input('device');

        $foodInfo = DishName::foodInfo($timeStart, $timeEnd, $device, $food);
        return $foodInfo;

    }


    public function foodSales(Request $request)
    {
        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);

        if ($checkTime !== 0) {
            return $checkTime;
        }

        $food = $request->input('food');
        $checkFood = CheckModel::checkFood($food);

        if ($checkFood !== 0) {
            return $checkFood;
        }


        $device = $request->input('device');


        $foodSales = DishName::foodSales($timeStart, $timeEnd, $device, $food);
        return $foodSales;

    }


    public function foodSalesDetail(Request $request)
    {

        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $food = $request->input('food');
        $checkFood = CheckModel::checkFood($food);

        if ($checkFood !== 0) {
            return $checkFood;
        }


        $device = $request->input('device');

        $foodSalesDetail = DishName::foodSalesDetail($timeStart, $timeEnd, $device, $food);
        return $foodSalesDetail;

    }


    public function foodSalesPackage(Request $request)
    {

        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $food = $request->input('food');
        $checkFood = CheckModel::checkFood($food);

        if ($checkFood !== 0) {
            return $checkFood;
        }


        $device = $request->input('device');

        $foodSalesPackage = OrderModel::foodSalesPackage($timeStart, $timeEnd, $device, $food);
        return $foodSalesPackage;
    }


    public function test(Request $request)
    {

        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $food = $request->input('food');
        $checkFood = CheckModel::checkFood($food);

        if ($checkFood !== 0) {
            return $checkFood;
        }


        $device = $request->input('device');

        $data = OrderModel::foodSalesPackage($timeStart, $timeEnd, $device, $food);
        return ExcelModel::makeExcel('', $data, 'test', 'xls');
    }


    public function exportSalesData(Request $request)
    {

        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $device = $request->input('device');

        $data = OrderModel::exportSalesData($timeStart, $timeEnd, $device);
        $title = array('订单号', '流水号', '设备编号', '时间', '总金额', '支付方式');

        $timeStart = str_replace('-', '', Carbon::parse($request->input('timeStart'))->toDateString());
        $timeEnd = str_replace('-', '', Carbon::parse($request->input('$timeEnd'))->toDateString());
        $fileName = '财务管理' . $timeStart . '-' . $timeEnd;
        return ExcelModel::makeExcel($title, $data, $fileName, 'xls');
    }


    public function exportSalesAnalData(Request $request)
    {
        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $device = $request->input('device');

        $data = OrderModel::exportSalesAnalData($timeStart, $timeEnd, $device);

        $title = array('订单号', '流水号', '设备编号', '时间', '餐品', '餐品单价');

        $timeStart = str_replace('-', '', Carbon::parse($request->input('timeStart'))->toDateString());
        $timeEnd = str_replace('-', '', Carbon::parse($request->input('$timeEnd'))->toDateString());
        $fileName = '菜品销量分析' . $timeStart . '-' . $timeEnd;
        return ExcelModel::makeExcel($title, $data, $fileName, 'xls');
    }


    public function exportSalesSearchData(Request $request)
    {

        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }


        $food = $request->input('food');

        $checkFood = CheckModel::checkFood($food);

        if ($checkFood !== 0) {
            return $checkFood;
        }

        $device = $request->input('device');

        $data = OrderModel::exportSalesSearchData($timeStart, $timeEnd, $device, $food);

        $title = array('订单号', '流水号', '设备编号', '时间', '餐品', '餐品单价');

        $timeStart = str_replace('-', '', Carbon::parse($request->input('timeStart'))->toDateString());
        $timeEnd = str_replace('-', '', Carbon::parse($request->input('$timeEnd'))->toDateString());
        $fileName = '菜品销量分析' . $timeStart . '-' . $timeEnd;
        return ExcelModel::makeExcel($title, $data, $fileName, 'xls');
    }


    public function exportDetail(Request $request)
    {
        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        $device = $request->input('device');

        $result = DataModel::orderDetial($timeStart, $timeEnd, $device);
        $data = $result->get();


        $title = array('编号', '设备编号', '日期', '时间', '订单总价', '餐具名称', '单价', '数量', '支付方式');

        $timeStart = str_replace('-', '', Carbon::parse($request->input('timeStart'))->toDateString());
        $timeEnd = str_replace('-', '', Carbon::parse($request->input('$timeEnd'))->toDateString());
        $fileName = '菜品销量分析' . $timeStart . '-' . $timeEnd;

        return ExcelModel::makeExcel($title, $data, $fileName, 'xls');
    }


    public function meatAndVege(Request $request)
    {
        $timeStart = Carbon::parse($request->input('timeStart'))->toDateTimeString();
        $timeEnd = Carbon::parse($request->input('timeEnd'))->toDateTimeString();

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        $device = $request->input('device');

        $result = OrderModel::meatAndVege($timeStart, $timeEnd, $device);

        return $result;
    }


}