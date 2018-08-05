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


class DishController extends Controller
{



    public function allFood(){
        return DishName::allFood();
    }



}