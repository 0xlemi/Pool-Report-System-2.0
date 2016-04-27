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
    return view('welcome');
});

Route::auth();

Route::resource('reports', 'ReportsController');
Route::get('reports/date/{date}', 'ReportsController@index_by_date');
Route::post('reports/photos/{seq_id}', 'ReportsController@addPhoto');

Route::resource('services', 'ServicesController');
Route::resource('clients', 'ClientsController');
Route::resource('supervisors', 'SupervisorsController');
Route::resource('technicians', 'TechniciansController');


// Route::get('/home', 'HomeController@index');
