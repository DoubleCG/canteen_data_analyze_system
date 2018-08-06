<?php

namespace App;

class ExcelModel {
	public static function makeExcel($title, $cellData, $fileName, $type) {

		// $cellData = json_decode(json_encode($cellData), true);

		// Excel::create($fileName, function ($excel) use ($cellData, $title, $fileName) {
		// 	$excel->sheet($fileName, function ($sheet) use ($cellData, $title) {
		// 		$sheet->fromArray($cellData, null, 'A1', false, false);
		// 		$sheet->prependRow(1, $title);
		// 	});
		// })->export($type);

	}
}
