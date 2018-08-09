<?php
use Illuminate\Http\Request;

// 获取当前已认证的用户...
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware(['auth:api'])->group(function () {
	// This line has some problem;
	Route::post('/logout', 'Auth\LoginController@logout');
	Route::get('/allDishSales', 'DataController@allDishSales');
	Route::get('/fincance', 'DataController@finance');
	Route::get('/orderDeital', 'DataController@orderDetial');
	Route::post('/orderCheck', 'DataController@orderCheck');
	Route::post('/popular', 'DataController@popular');

});
// ============================================

Route::get('/news', 'DataController@news');
// Route::get('/downloadExcel', 'DataController@export');
// Route::get('/downloadExcel', 'ExportController@exportExcel');
// Route::get('/downloadExcel', 'ExportController@export');
Route::get('/downloadExcel', 'UsersController@collection');

Route::prefix('home')->group(function () {
	Route::get('/singlePopular', 'HomeController@singlePopular');
	Route::get('/multiplePopular', 'HomeController@multiplePopular');
	Route::get('/moneyOverView', 'HomeController@moneyOverView');
	Route::get('/payType', 'HomeController@payType');
	Route::get('/weekFinance', 'HomeController@WeekFinance');
	Route::get('/todayClient', 'HomeController@TodayClient');
});

Route::get('/dishName', 'DataController@dishName');
Route::get('/user', function (Request $request) {
	// Get the user making the request.
	return $request->user();
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
Route::get('/test', function (Request $request) {
	return $request->user();
});

// Route::get('')
