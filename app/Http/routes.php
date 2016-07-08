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

Route::get('/', function () {
	if(Auth::check()){
		return view('home');
	}
    return view('landing.welcome');
});

Route::auth();

Route::resource('reports', 'ReportsController');
Route::get('reports/date/{date}', 'ReportsController@index_by_date');
Route::post('reports/photos/{seq_id}', 'ReportsController@addPhoto');
Route::delete('reports/photos/{seq_id}/{order}', 'ReportsController@removePhoto');

Route::resource('services', 'ServicesController');
Route::resource('clients', 'ClientsController');
Route::resource('supervisors', 'SupervisorsController');
Route::resource('technicians', 'TechniciansController');

Route::get('chat', 'ChatController@home');

Route::get('settings', 'SettingsController@settings');
Route::patch('settings/company', 'SettingsController@updateCompany');
Route::patch('settings/email', 'SettingsController@updateEmail');
Route::patch('settings/password', 'SettingsController@updatePassword');

Route::group(['prefix' => 'api/v1'], function(){
	Route::get('user', 'Api\SettingsController@information');
	Route::resource('services', 'Api\ServicesController');
	Route::resource('supervisors', 'Api\SupervisorsController');
	Route::resource('technicians', 'Api\TechniciansController');
	Route::resource('clients', 'Api\ClientsController');
	Route::resource('reports', 'Api\ReportsController');
});


// Route::get('/home', 'HomeController@index');
