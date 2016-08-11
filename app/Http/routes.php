<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::auth();

Route::get('reports/emailPreview', 'ReportsController@emailPreview');
Route::post('reports/photos/{seq_id}', 'ReportsController@addPhoto');
Route::delete('reports/photos/{seq_id}/{order}', 'ReportsController@removePhoto');

Route::resource('reports', 'ReportsController');
Route::resource('services', 'ServicesController');
Route::resource('clients', 'ClientsController');
Route::resource('supervisors', 'SupervisorsController');
Route::resource('technicians', 'TechniciansController');

Route::get('chat', 'ChatController@home');

Route::get('settings', 'SettingsController@index');
Route::patch('settings/account', 'SettingsController@account');
Route::patch('settings/changeEmail', 'SettingsController@changeEmail');
Route::patch('settings/changePassword', 'SettingsController@changePassword');
Route::patch('settings/company', 'SettingsController@company');
Route::patch('settings/email', 'SettingsController@email');
Route::patch('settings/billing', 'SettingsController@billing');
Route::patch('settings/permissions', 'SettingsController@permissions');

Route::get('datatables/reports', 'DataTableController@reports');
Route::get('datatables/services', 'DataTableController@services');
Route::get('datatables/clients', 'DataTableController@clients');
Route::get('datatables/supervisors', 'DataTableController@supervisors');
Route::get('datatables/technicians', 'DataTableController@technicians');

Route::group(['prefix' => 'api/v1', 'middleware' => ['api', 'throttle:10'] ], function (){
	Route::post('login', 'Api\UserController@login');
	Route::post('signUp', 'Api\AdministratorsController@store');
});

Route::group(['prefix' => 'api/v1', 'middleware' => ['api', 'auth:api'] ], function(){
	// Route::get('user', 'Api\SettingsController@information');
	Route::post('resetToken', 'Api\UserController@resetToken');

	Route::resource('services', 'Api\ServicesController');
	Route::resource('supervisors', 'Api\SupervisorsController');
	Route::resource('technicians', 'Api\TechniciansController');
	Route::resource('clients', 'Api\ClientsController');
	Route::resource('reports', 'Api\ReportsController');

	Route::post('settings/account', 'Api\SettingsController@account');
	Route::post('settings/permissions', 'Api\SettingsController@permissions');
});


// Route::get('/home', 'HomeController@index');
