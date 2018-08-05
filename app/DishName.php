<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DishName extends Model
{
    //
    protected $table = 'demodishname';
    public $timestamps = false;
    
    
    public static function foodInfo($timeStart, $timeEnd, $device, $food)
    {
        if (ctype_digit($food)) {
            $result = DishName::where('demodishname.ID', '=', $food);
        } else {
            $result = DishName::where('demodishname.dishname', '=', $food);
        }
        
        $result = $result->join('demoorderitem', 'demodishname.PicName', '=', 'demoorderitem.PicName')
            ->join('demoorder', 'demoorder.ID', '=', 'demoorderitem.OrderID');
        
        
        if (!empty($device)) {
            $result = $result->select(DB::raw('
                demoorder.ClientID clientid,
                demodishname.ID foodID,
                demodishname.dishname dishname,
                demoorderitem.Name price,
                sum(demoorderitem.Number) count,
                demoorderitem.Name * sum(demoorderitem.Number) sales
            '));
        } else {
            $result = $result->select(DB::raw('
                demodishname.ID foodID,
                demodishname.dishname dishname,
                demoorderitem.Name price,
                sum(demoorderitem.Number) count,
                demoorderitem.Name * sum(demoorderitem.Number) sales
            '));
        }
        
        $result = $result->whereBetween('demoorder.Date_time', [$timeStart, $timeEnd]);
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
        
        if (ctype_digit($food)) {
            $result = DishName::where('demodishname.ID', '=', $food);
        } else {
            $result = DishName::where('demodishname.dishname', '=', $food);
        }
        
        $result = $result->join('demoorderitem', 'demodishname.PicName', '=', 'demoorderitem.PicName')
            ->join('demoorder', 'demoorder.ID', '=', 'demoorderitem.OrderID');
        
        if (!empty($device)) {
            
            $result = $result->select(DB::raw('
                    demoorder.ClientID clientid,
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    demoorder.ID id,
                    demodishname.dishname dishname,
                    demodishname.ID foodID,
                    sum(demoorderitem.Number) count
                    '));
            
        } else {
            $result = $result->select(DB::raw('
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    DATE_FORMAT(Date_time,\'%Y-%m-%d\') date,
                    demoorder.ID id,
                    demodishname.dishname dishname,
                    demodishname.ID foodID,
                    sum(demoorderitem.Number) count
                    '));
        }
        
        
        $result = $result->whereBetween('demoorder.Date_time', [$timeStart, $timeEnd])
            ->groupBy('date');
        
        
        if (!empty($device)) {
            $result = $result->where('clientid', 'like', $device . '%')->groupBy('clientid');
        }
        
        
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
            $result = DishName::where('demodishname.ID', '=', $food);
        } else {
            $result = DishName::where('demodishname.dishname', '=', $food);
        }
        
        $result = $result->join('demoorderitem', 'demodishname.PicName', '=', 'demoorderitem.PicName')
            ->join('demoorder', 'demoorder.ID', '=', 'demoorderitem.OrderID');
        
        if (!empty($device)) {
            
            $result = $result->select(DB::raw('
                    demoorder.ClientID clientid,
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    Date_time date,
                    demoorder.ID id,
                    demodishname.dishname dishname,
                    demodishname.ID foodID,
                    demoorderitem.Number count
                    '));
            
        } else {
            $result = $result->select(DB::raw('
                    YEAR(Date_time) year,
                    MONTH(Date_time) month,
                    DAY(Date_time) day,
                    Date_time date,
                    demoorder.ID id,
                    demodishname.dishname dishname,
                    demodishname.ID foodID,
                    demoorderitem.Number count
                    '));
        }
        
        
        $result = $result->whereBetween('demoorder.Date_time', [$timeStart, $timeEnd]);
        
        
        $result = $result->where('clientid', 'like', $device . '%');
        
        
        return $result->get();
    }
    
    public static function popularDish($timeStart, $timeEnd, $device, $food)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        
        $checkFood = CheckModel::checkFood($food);
        if ($checkFood !== 0) {
            return $checkFood;
        }
    }
    
    public static function foodSalesPackage($timeStart, $timeEnd, $device, $food)
    {
        $checkTime = CheckModel::checkDateRange($timeStart, $timeEnd);
        if ($checkTime !== 0) {
            return $checkTime;
        }
        
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
                        count(*) count
                        '
            ));
        } else {
            $result =$result->select(DB::raw('
                        sub.package,
                        sub.price,
                        sub.totalPrice,
                        count(*) count
                        '
            ));
        }
        $result = $result
            ->groupBy('sub.package')
            ->where('sub.package', 'like', '%' . $food . '%')
            ->orderBy('count', 'desc');
        
        return $result->get();
    }



    public static function allFood(){
        $result = DishName::select(DB::raw('
                    ID value,
                    dishname label'));


        return $result -> get();
    }
    
}