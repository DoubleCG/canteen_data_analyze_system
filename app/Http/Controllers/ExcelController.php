<?php

namespace App\Http\Controllers;

use App\DataModel;
use App\ExcelModel;
use Illuminate\Http\Request;

use Excel;

class ExcelController extends Controller
{
    //class ExcelController extends Controller
    //Excel文件导出功能 By Laravel学院
    
    
    
    public function exportExcel(Request $request)
    {
        $title = $request->input('title');
        $tableData = $request->input('tableData');
        $fileName = $request->input('fileName');
        $source = $request->input('source');
        $type = $request->input('type');
        
        
        
//        switch ($source) {
//            case 'OrderDeital':
//                $cellData = DataModel::orderDetial($queryData);
//                break;
//            case 'Finance':
//                $cellData = DataModel::finance($queryData);
//                break;
//            case 'Popular':
//                $cellData = DataModel::popular($queryData);
//                break;
//            case 'Sales':
//                $cellData = DataModel::dishSales($queryData);
//                break;
//        }
//
        ExcelModel::makeExcel($title, $tableData, $fileName, $type);
        
    }
    
}
