<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

// change email settings from link
Route::group(['middleware' => ['throttle:500'] ], function (){
    Route::get('/unsubscribe/{token}', 'HomeController@emailOptions');
    Route::post('/unsubscribe', 'HomeController@changeEmailOptions');
});

// not sure about this one
Route::auth();

// remove this eventually
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('reports/emailPreview', 'ReportsController@emailPreview');
Route::post('reports/photos/{seq_id}', 'ReportsController@addPhoto');
Route::delete('reports/photos/{seq_id}/{order}', 'ReportsController@removePhoto');


Route::post('equipment/photos/{id}', 'EquipmentController@addPhoto');
Route::delete('equipment/photos/{id}/{order}', 'EquipmentController@removePhoto');

Route::resource('reports', 'ReportsController');
Route::resource('workorders', 'WorkOrderController');
Route::resource('services', 'ServicesController');
Route::resource('equipment', 'EquipmentController');
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
Route::get('datatables/workorders', 'DataTableController@workOrders');
Route::get('datatables/missingServices', 'DataTableController@missingServices');
Route::get('datatables/missingServicesInfo', 'DataTableController@missingServicesInfo');
Route::get('datatables/services', 'DataTableController@services');
Route::get('datatables/equipment/{service_seq_id}', 'DataTableController@equipment');
Route::get('datatables/clients', 'DataTableController@clients');
Route::get('datatables/supervisors', 'DataTableController@supervisors');
Route::get('datatables/technicians', 'DataTableController@technicians');
