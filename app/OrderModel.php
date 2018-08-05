<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModel extends Model
{
    //
    protected $table = 'demoorder';
    public $timestamps = false;


    public static function orderNum($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        if (!empty($device)) {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                ClientID clientid,
                COUNT(1) count
            '));
        } else {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                COUNT(1) count
            '));
        }

        $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%')->groupBy('ClientID');

        }


        return $result->get();

    }

    public static function turnover($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        if (!empty($device)) {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                 ClientID clientid,
                 sum(Total_money) money
                '));
        } else {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                 sum(Total_money) money
                '));
        }

        $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%')->groupBy('ClientID');

        }

        return $result->get();

    }

    public static function turnoverDetail($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }


        if (!empty($device)) {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                        ClientID clientid,
                        YEAR(Date_time) year,
                        MONTH(Date_time) month,
                        DAY(Date_time) day,
                        DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                        COUNT(1) count,
                        SUM(Total_money) money'));
        } else {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                        YEAR(Date_time) year,
                        MONTH(Date_time) month,
                        DAY(Date_time) day,
                        DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                        COUNT(1) count,
                        SUM(Total_money) money'));
        }


        $result = $result
            ->whereBetween('Date_time', [$timeStart, $timeEnd]);


        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%');

        }


        $result = $result
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->orderBy('day', 'asc')
            ->groupBy('year', 'month', 'day');


        if (!empty($device)) {
            $result = $result
                ->groupBy('ClientID');
        }

        $result = $result->get();


        return $result;
    }

    public static function oderMoneyDistribute($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        if (!empty($device)) {
            $result = DB::table('demoorder')
                ->select(DB::raw('

                        COUNT(1) count,
                        Total_money money'));
        } else {
            $result = DB::table('demoorder')
                ->select(DB::raw('

                        COUNT(1) count,
                        Total_money money'));
        }


        $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);
        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%')->groupBy('ClientID');
        }
        $result = $result
            ->groupBy('money');

        if (!empty($device)) {
            $result = $result
                ->groupBy('ClientID');
        }

        $result = $result->get();


        return $result;
    }

    public static function payType($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        if (!empty($device)) {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                        ClientID clientid,
                        COUNT(1) count,
                        Pay_type payType'));
        } else {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                        COUNT(1) count,
                        Pay_type payType'));
        }

        $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%')->groupBy('ClientID');
        }

        $result = $result
            ->groupBy('payType');

        if (!empty($device)) {
            $result = $result
                ->groupBy('ClientID');
        }

        $result = $result->get();


        return $result;

    }

    public static function popularPackage($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
            ->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName');
        if (!empty($device)) {
            $sub = $sub
                ->select(DB::raw('
                    demoorder.ClientID clientid,
                    demoorder.ID id,
                    GROUP_CONCAT( demodishname.dishname, \'*\', Number order by demodishname.dishname ) package,
                    GROUP_CONCAT( demoorderitem.Name, \'*\', Number order by demodishname.dishname ) price,
                    demoorder.Total_money totalPrice

                    '));

        } else {
            $sub = $sub
                ->select(DB::raw('
                    demoorder.ID id,
                    GROUP_CONCAT( demodishname.dishname, \'*\', Number order by demodishname.dishname ) package,
                    GROUP_CONCAT( demoorderitem.Name, \'*\', Number order by demodishname.dishname ) price,
                    demoorder.Total_money totalPrice

                    '));

        }
        $sub = $sub->whereBetween('Date_time', [$timeStart, $timeEnd])
            ->groupBy('id');


        if (!empty($device)) {
            $sub = $sub->where('demoorder.ClientID', 'like', $device . '%')->groupBy('ClientID');
        }


        $result = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->mergeBindings($sub->getQuery());// 非常重要 文档里没有提

        if (!empty($device)) {
            $result = $result->select(DB::raw('
                        sub.clientid,
                        sub.package,
                        sub.price,
                        sub.totalPrice,
                        count(*) count,
                        sub.totalPrice * count(*) sales
                        '
            ));
        } else {
            $result = $result->select(DB::raw('
                        sub.package,
                        sub.price,
                        sub.totalPrice,
                        count(*) count,
                        sub.totalPrice * count(*) sales
                        '
            ));
        }
        if (!empty($device)) {
            $result = $result->groupBy('sub.clientid');
        }

        $result = $result
            ->groupBy('sub.package')
            ->orderBy('count', 'desc');

        return $result->get();
    }

    public static function popularFood($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
            ->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName');
        if (!empty($device)) {
            $sub = $sub->select(DB::raw('
                    demoorder.ClientID clientid,
                    demoorder.ID id,
                    demodishname.dishname foodname,
                    demoorderitem.Name price,
                    sum(demoorderitem.Number) subcount
                    
                    '));


        } else {
            $sub = $sub
                ->select(DB::raw('
                    demoorder.ID id,
                    demodishname.dishname foodname,
                    demoorderitem.Name price,
                    sum(demoorderitem.Number) subcount
                    
                    '));
        }

        $sub = $sub->whereBetween('Date_time', [$timeStart, $timeEnd])
            ->groupBy('id');


        if (!empty($device)) {
            $sub = $sub->where('demoorder.ClientID', 'like', $device . '%')->groupBy('clientid');
        }

        $result = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->mergeBindings($sub->getQuery());// 非常重要 文档里没有提

        if (!empty($device)) {
            $result = $result->select(DB::raw('
                        sub.clientid,
                        sub.foodname,
                        sub.price,
                        sum(subcount) count,
                        sub.price * sum(subcount) money
                        '
            ));
        } else {
            $result = $result->select(DB::raw('
                        sub.foodname,
                        sub.price,
                        sum(subcount) count,
                        sub.price * sum(subcount) money
                        '
            ));
        }

        if (!empty($device)) {
            $result = $result->groupBy('sub.clientid');
        }


        $result = $result->groupBy('sub.foodname')
            ->orderBy('count', 'desc');
        return $result->get();

    }

    public static function foodInfo($timeStart, $timeEnd, $device, $food)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $checkFood = CheckModel::checkFood($food);
        if ($checkFood !== 0) {
            return $checkFood;
        }

        if (ctype_digit($food)) {
            if (!empty($device)) {
                $result = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
                    ->join('demodishname', $food, '=', 'demodishname.ID')
                    ->select(DB::raw('
                        demodishname.dishname dishname,
                        demodishname.ID foodID,
                        count(1) count,
                        demoorderitem.Name price
                    '));
            } else {
//                $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
//                    ->join('demofoodname', 'demoorderitem.PicName', '=', 'demofoodname.PicName')
//                    ->select(DB::raw('
//                    demoorder.ClientID clientid,
//                    demoorder.ID id,
//                    demofoodname.ID foodID,
//                    demofoodname.FoodName foodname,
//                    demoorderitem.Name price
//                    '))
//                    ->whereBetween('Date_time', [$timeStart, $timeEnd])
//                    ->where('demofoodname.ID', '=', $food)
//                    ->where('demofoodname.FoodID', '=', 'demoorderitem.Number')
//                    ->groupBy('id');
            }
        } else {
            if (!empty($device)) {
//                $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
//                    ->join('demofoodname', 'demoorderitem.PicName', '=', 'demofoodname.PicName')
//                    ->select(DB::raw('
//                    demoorder.ClientID clientid,
//                    demoorder.ID id,
//                    demofoodname.ID foodID,
//                    demofoodname.FoodName foodname,
//                    demoorderitem.Name price
//                    '))
//                    ->whereBetween('Date_time', [$timeStart, $timeEnd])
//                    ->where('demofoodname.FoodName', '=', $food)
//                    ->where('demofoodname.FoodID', '=', 'demoorderitem.Number')
//                    ->groupBy('id');

            } else {
//                $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
//                    ->join('demofoodname', 'demoorderitem.PicName', '=', 'demofoodname.PicName')
//                    ->select(DB::raw('
//                    demoorder.ClientID clientid,
//                    demoorder.ID id,
//                    demofoodname.ID foodID,
//                    demofoodname.FoodName foodname,
//                    demoorderitem.Name price
//                    '))
//                    ->whereBetween('Date_time', [$timeStart, $timeEnd])
//                    ->where('demofoodname.FoodName', '=', $food)
//                    ->where('demofoodname.FoodID', '=', 'demoorderitem.Number')
//                    ->groupBy('id');
            }
        }


        $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

        if (!empty($device)) {
            $result = $result->where('demoorder.ClientID', 'like', $device . '%')->groupBy('demoorder.ClientID');
        }


        return $result->get();

    }

    public static function foodSales($timeStart, $timeEnd, $device, $food)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $checkFood = CheckModel::checkFood($food);
        if ($checkFood !== 0) {
            return $checkFood;
        }
        if (intval($food) !== 0) {
            if (!empty($device)) {
                $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
                    ->join('demofoodname', 'demoorderitem.PicName', '=', 'demofoodname.PicName')
                    ->select(DB::raw('
                    demoorder.ClientID clientid,
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    demoorder.ID id,
                    demofoodname.FoodName foodname
                    '))
                    ->whereBetween('Date_time', [$timeStart, $timeEnd])
                    ->where('demofoodname.ID', '=', $food)
                    ->where('demofoodname.FoodID', '=', 'demoorderitem.Number')
                    ->groupBy('id');


            } else {
                $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
                    ->join('demofoodname', 'demoorderitem.PicName', '=', 'demofoodname.PicName')
                    ->select(DB::raw('
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    demoorder.ID id,
                    demofoodname.FoodName foodname
                    '))
                    ->whereBetween('Date_time', [$timeStart, $timeEnd])
                    ->where('demofoodname.ID', '=', $food)
                    ->where('demofoodname.FoodID', '=', 'demoorderitem.Number')
                    ->groupBy('id');
            }
        } else {
            if (!empty($device)) {
                $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
                    ->join('demofoodname', 'demoorderitem.PicName', '=', 'demofoodname.PicName')
                    ->select(DB::raw('
                    demoorder.ClientID clientid,
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    demoorder.ID id,
                    demofoodname.FoodName foodname
                    '))
                    ->whereBetween('Date_time', [$timeStart, $timeEnd])
                    ->where('demofoodname.FoodName', '=', $food)
                    ->where('demofoodname.FoodID', '=', 'demoorderitem.Number')
                    ->groupBy('id');

            } else {
                $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
                    ->join('demofoodname', 'demoorderitem.PicName', '=', 'demofoodname.PicName')
                    ->select(DB::raw('
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    demoorder.ID id,
                    demofoodname.FoodName foodname
                    '))
                    ->whereBetween('Date_time', [$timeStart, $timeEnd])
                    ->where('demofoodname.FoodName', '=', $food)
                    ->where('demofoodname.FoodID', '=', 'demoorderitem.Number')
                    ->groupBy('id');
            }
        }

        if (!empty($device)) {
            $sub = $sub->where('demoorder.ClientID', 'like', $device . '%');
        }

        $result = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->mergeBindings($sub->getQuery())// 非常重要 文档里没有提
            ->select(DB::raw('
                        sub.foodname,
                        sub.date,
                        count(*) count
                        '
            ))
            ->groupBy('sub.foodname')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->orderBy('day', 'asc')
            ->groupBy('year', 'month', 'day');

        return $result->get();

    }

    public static function foodSalesDetail($timeStart, $timeEnd, $device, $food)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $checkFood = CheckModel::checkFood($food);
        if ($checkFood !== 0) {
            return $checkFood;
        }

        if (ctype_digit($food)) {
            $result = DB::table('demodishname')->where('demodishname.ID', '=', $food)
                ->join('demoorderitem', 'demodishname.PicName', '=', 'demoorderitem.PicName')
                ->join('demoorder', 'demoorderitem.OrderID', '=', 'demoorder.ID')
                ->whereBetween('Date_time', [$timeStart, $timeEnd])
                ->select(DB::raw('
                    demoorderitem.Name price,
                    demoorder.Date_time date,
                    demoorder.ID orderid,
                    ClientID clientid,
                    demoorderitem.Number count,
                    demoorderitem.Name * demoorderitem.Number sales
            '));
        } else {
            $result = DB::table('demodishname')->where('demodishname.dishname', '=', $food)
                ->join('demoorderitem', 'demodishname.PicName', '=', 'demoorderitem.PicName')
                ->join('demoorder', 'demoorderitem.OrderID', '=', 'demoorder.ID')
                ->whereBetween('Date_time', [$timeStart, $timeEnd])
                ->select(DB::raw('
                    demoorderitem.Name price,
                    demoorder.Date_time date,
                    demoorder.ID orderid,
                    ClientID clientid,
                    demoorderitem.Number count,
                    demoorderitem.Name * demoorderitem.Number sales
            '));

        }

//
//        if (!empty($device)) {
//            $result = $result->where('ClientID', 'like', $device . '%')->groupBy('ClientID');
//        }
//

        return $result->get();

    }

    public static function foodSalesPackage($timeStart, $timeEnd, $device, $food)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $checkFood = CheckModel::checkFood($food);
        if ($checkFood !== 0) {
            return $checkFood;
        }


        if (ctype_digit($food)) {
            $food = DishName::where('ID', '=', $food)->select('dishname')->get();
        }
        $food = $food[0]['dishname'];

        $sub = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
            ->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName');
        if (!empty($device)) {
            $sub = $sub
                ->select(DB::raw('
                    demoorder.ClientID clientid,
                    demoorder.ID id,
                    GROUP_CONCAT( demodishname.dishname, \'*\', Number order by demodishname.dishname ) package,
                    GROUP_CONCAT( demoorderitem.Name, \'*\', Number order by demodishname.dishname ) price,
                    demoorder.Total_money totalPrice

                    '));

        } else {
            $sub = $sub
                ->select(DB::raw('
                    demoorder.ID id,
                    GROUP_CONCAT( demodishname.dishname, \'*\', Number order by demodishname.dishname ) package,
                    GROUP_CONCAT( demoorderitem.Name, \'*\', Number order by demodishname.dishname ) price,
                    demoorder.Total_money totalPrice

                    '));

        }
        $sub = $sub->whereBetween('Date_time', [$timeStart, $timeEnd])
            ->groupBy('id');


        if (!empty($device)) {
            $sub = $sub->where('demoorder.ClientID', 'like', $device . '%')->groupBy('ClientID');
        }


        $result = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->mergeBindings($sub->getQuery());// 非常重要 文档里没有提

        if (!empty($device)) {
            $result = $result->select(DB::raw('
                        sub.clientid,
                        sub.package,
                        sub.price,
                        sub.totalPrice,
                        count(*) count,
                        sub.totalPrice * count(*) sales
                        '
            ));
        } else {
            $result = $result->select(DB::raw('
                        sub.package,
                        sub.price,
                        sub.totalPrice,
                        count(*) count,
                        sub.totalPrice * count(*) sales
                        '
            ));
        }
        $result = $result
            ->groupBy('sub.package')
            ->where('sub.package', 'like', '%' . $food . '%')
            ->orderBy('count', 'desc');

        return $result->get();
    }


    public static function trafficDetail($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        if (!empty($device)) {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                ClientID clientid,

                COUNT(1) count
            '));
        } else {
            $result = DB::table('demoorder')
                ->select(DB::raw('

                COUNT(1) count
            '));
        }

        $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);

        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%')->groupBy('ClientID');

        }


        return $result->get();

    }


    public static function avClient($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        if (!empty($device)) {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                ClientID clientid,
                YEAR(Date_time) year,
                MONTH(Date_time) month,
                DAY(Date_time) day,
                HOUR(Date_time) hour,
                FLOOR(MINUTE(Date_time)/5) * 5 mins,
                COUNT(1) count
            '));
        } else {
            $result = DB::table('demoorder')
                ->select(DB::raw('
                YEAR(Date_time) year,
                MONTH(Date_time) month,
                DAY(Date_time) day,
                HOUR(Date_time) hour,
                FLOOR(MINUTE(Date_time)/5) * 5 mins,
                COUNT(1) count
            '));
        }


        $result = $result->whereBetween('Date_time', [$timeStart, $timeEnd]);


        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%')->groupBy('ClientID');

        }


        $result = $result
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->orderBy('day', 'asc')
            ->orderBy('hour', 'asc')
            ->orderBy('mins', 'asc')
            ->groupBy('year', 'month', 'day')
            ->groupBy('hour')
            ->groupBy('mins');


        return $result->get();
    }


    public static function exportSalesData($timeStart, $timeEnd, $device)
    {

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $result = OrderModel::select('ID', 'Order_number', 'ClientID', 'Date_time', 'Total_money', 'Pay_type')
            ->whereBetween('Date_time', [$timeStart, $timeEnd]);

        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%');
        }
        return $result->get();

    }

    public static function exportSalesAnalData($timeStart, $timeEnd, $device)
    {

        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $result = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
            ->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName')
            ->select(DB::raw('
                demoorder.ID,
                demoorder.Order_number,
                demoorder.ClientID,
                demoorder.Date_time,
                demodishname.dishname,
                demoorderitem.Name
                '))
            ->whereBetween('Date_time', [$timeStart, $timeEnd]);

        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%');
        }
        return $result->get();

    }


    public static function exportSalesSearchData($timeStart, $timeEnd, $device, $food)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $checkFood = CheckModel::checkFood($food);
        if ($checkFood !== 0) {
            return $checkFood;
        }


        if (ctype_digit($food)) {
            $food = DishName::where('ID', '=', $food)->select('dishname')->get();
        }
        $food = $food[0]['dishname'];

        $result = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
            ->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName')
            ->select(DB::raw('
                demoorder.ID,
                demoorder.Order_number,
                demoorder.ClientID,
                demoorder.Date_time,
                demodishname.dishname,
                demoorderitem.Name
                '))
            ->whereBetween('Date_time', [$timeStart, $timeEnd])
            ->where('dishname', '=', $food);

        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%');
        }
        return $result->get();
    }


    public static function meatAndVege($timeStart, $timeEnd, $device)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }

        $result = OrderModel::join('demoorderitem', 'demoorder.ID', '=', 'demoorderitem.OrderID')
            ->join('demodishname', 'demoorderitem.PicName', '=', 'demodishname.PicName')
            ->select(DB::raw('
                 count(*) count,
                 demoorderitem.Name,
                 demodishname.dishname,
                 demodishname.attributes,
                 count(*) * demoorderitem.Name sales
                '))
            ->whereBetween('Date_time', [$timeStart, $timeEnd])
            ->where('attributes', '<>', 'basic')
            ->where('attributes', '<>', 'package')
            ->groupBy('attributes')
            ->groupBy('dishname')
            ->orderBy('count', 'desc');

        if (!empty($device)) {
            $result = $result->where('ClientID', 'like', $device . '%');
        }
        return $result->get();
    }


}

