<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckModel
{
    public static function finance($timeStart, $timeEnd, $type, $num)
    {
        
        
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
        
        return $result->groupBy('date');;
    }
    
    public static function checkDateRange($timeStart, $timeEnd)
    {
        if (empty($timeStart)) {
            return 'empty timeStart';
        }
        
        if (empty($timeEnd)) {
            return 'empty timeEnd';
        }
        
        if ($timeStart > $timeEnd) {
            return 'timeStart should be earlier than timeEnd';
        }
        
        $now = Carbon::now()->toDateTimeString();
        if ($timeStart > $now || $timeEnd > $now) {
            return 'are you come form future?';
        }
        
        return 0;
    }
    
    public static function checkFood($food)
    {
        if (ctype_digit($food)) {
            if ($food === '0' || $food < 0) {
                return 'foodID should bigger than 0';
            } else {
                $result = DB::table('demodishname')->where('ID', '=', $food)->get();
                if (!count($result)) {
                    return 'invaild foodID';
                }
            }
        } else {
            $result = DB::table('demodishname')->where('dishname', '=', $food)->get();
            if (!count($result)) {
                return 'invaild food';
            }
        }
        
        return 0;
    }


    public static function checkAuth(){

    }
}
