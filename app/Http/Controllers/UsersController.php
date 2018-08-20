<?php
use App\Http\Controllers\Controller;
use App\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller {
	public function export() {
		return Excel::download(new UsersExport, 'users.xlsx');
	}
}
