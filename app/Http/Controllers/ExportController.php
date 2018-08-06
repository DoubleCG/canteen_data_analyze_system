<?php

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller {
	public function export() {
		return Excel::download(new UsersExport, 'users.xlsx');
	}

	// public function exportExcel(Request $request) {
	// 	$title = $request->input('title');
	// 	$tableData = $request->input('tableData');
	// 	$fileName = $request->input('fileName');
	// 	$source = $request->input('source');
	// 	$type = $request->input('type');

	// 	ExcelModel::makeExcel($title, $tableData, $fileName, $type);
	// }

}
