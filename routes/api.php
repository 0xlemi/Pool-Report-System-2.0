<?php

use Illuminate\Http\Request;

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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::group(['middleware' => ['throttle:10'] ], function (){
	Route::post('login', 'Api\UserController@login');
	Route::post('signup', 'Api\AdministratorsController@store');
});

Route::group(['middleware' => ['auth:api'] ], function(){
	Route::get('todaysroute', 'Api\UserController@todaysRoute');
	Route::post('resettoken', 'Api\UserController@resetToken');
	Route::get('account', 'Api\UserController@show');
	Route::post('account', 'Api\UserController@update');

	Route::post('permissions', 'Api\AdministratorsController@permissions');

	// Equipment
	Route::get('services/{serviceSeqId}/equipment', 'Api\EquipmentController@index');
	Route::post('services/{serviceSeqId}/equipment', 'Api\EquipmentController@store');
	Route::get('equipment/{equipment}', 'Api\EquipmentController@show');
	Route::post('equipment/{equipment}', 'Api\EquipmentController@update');
	Route::delete('equipment/{equipment}', 'Api\EquipmentController@destroy');

	// WorkOrder
	Route::resource('workorders', 'Api\WorkOrderController');
	Route::post('workorders/{seq_id}/finish', 'Api\WorkOrderController@finish');

	// Work
	// Route::get('work/{work}', 'Api\WorkController@show');

	Route::resource('services', 'Api\ServicesController');
	Route::resource('supervisors', 'Api\SupervisorsController');
	Route::resource('technicians', 'Api\TechniciansController');
	Route::resource('clients', 'Api\ClientsController');
	Route::resource('reports', 'Api\ReportsController');
});
