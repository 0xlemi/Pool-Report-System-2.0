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
	Route::post('signUp', 'Api\AdministratorsController@store');
});

Route::group(['middleware' => ['auth:api'] ], function(){
	Route::get('todaysRoute', 'Api\UserController@todaysRoute');
	Route::post('resetToken', 'Api\UserController@resetToken');
	Route::get('account', 'Api\UserController@show');
	Route::post('account', 'Api\UserController@update');

	Route::post('permissions', 'Api\AdministratorsController@permissions');

	Route::resource('services', 'Api\ServicesController');
	Route::resource('supervisors', 'Api\SupervisorsController');
	Route::resource('technicians', 'Api\TechniciansController');
	Route::resource('clients', 'Api\ClientsController');
	Route::resource('reports', 'Api\ReportsController');
});
