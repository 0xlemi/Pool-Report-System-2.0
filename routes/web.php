<?php
use Illuminate\Http\Request;

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
Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'HomeController@index');
Route::get('/home', 'HomeController@index');

// change email settings from link
Route::group(['middleware' => ['throttle:500'] ], function (){
    Route::get('/unsubscribe/{token}', 'HomeController@emailOptions');
    Route::post('/unsubscribe', 'HomeController@changeEmailOptions');
});

// remove this eventually
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('todaysroute', 'TodaysRouteController@index');
Route::get('todaysroute/report/{service_seq_id}', 'TodaysRouteController@createReport');
Route::post('todaysroute/report', 'TodaysRouteController@storeReport');

Route::get('reports/emailPreview', 'ReportsController@emailPreview');
Route::post('reports/photos/{seq_id}', 'ReportsController@addPhoto');
Route::delete('reports/photos/{seq_id}/{order}', 'ReportsController@removePhoto');

Route::post('workorders/finish/{seq_id}', 'WorkOrderController@finish');
Route::get('workorders/photos/before/{id}', 'WorkOrderController@getPhotosBefore');
Route::get('workorders/photos/after/{id}', 'WorkOrderController@getPhotosAfter');
Route::post('workorders/photos/before/{id}', 'WorkOrderController@addPhotoBefore');
Route::post('workorders/photos/after/{id}', 'WorkOrderController@addPhotoAfter');
Route::delete('workorders/photos/before/{id}/{order}', 'WorkOrderController@removePhotoBefore');
Route::delete('workorders/photos/after/{id}/{order}', 'WorkOrderController@removePhotoAfter');

Route::get('service/{workOrderSeqId}/works', 'WorkController@index');
Route::post('service/{workOrderSeqId}/works', 'WorkController@store');
Route::post('works/photos/{work}', 'WorkController@addPhoto');
// Route::delete('works/photos/{work}/{order}', 'WorkController@removePhoto');

Route::post('equipment/photos/{id}', 'EquipmentController@addPhoto');
Route::delete('equipment/photos/{id}/{order}', 'EquipmentController@removePhoto');

Route::get('chemicals/{serviceSeqId}', 'chemicalController@index');
Route::post('chemicals/{serviceSeqId}', 'chemicalController@store');

Route::get('servicecontracts/{serviceSeqId}', 'ServiceContractsController@show');
Route::post('servicecontracts/{serviceSeqId}', 'ServiceContractsController@store');
Route::patch('servicecontracts/{serviceSeqId}', 'ServiceContractsController@update');
Route::post('servicecontracts/{serviceSeqId}/active', 'ServiceContractsController@toggleActivation');
Route::delete('servicecontracts/{serviceSeqId}', 'ServiceContractsController@destroy');

Route::resource('reports', 'ReportsController');
Route::resource('workorders', 'WorkOrderController');
Route::resource('works', 'WorkController', ['only' => [
    'show', 'update', 'destroy'
]]);
Route::resource('services', 'ServicesController');
Route::resource('equipment', 'EquipmentController', ['only' => [
    'store', 'show', 'update', 'destroy'
]]);
Route::resource('chemicals', 'chemicalController', ['only' => [
    'update', 'destroy'
]]);
Route::resource('clients', 'ClientsController');
Route::resource('supervisors', 'SupervisorsController');
Route::resource('technicians', 'TechniciansController');

Route::get('chat', 'ChatController@home');

Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);

Route::get('settings', 'SettingsController@index');
Route::patch('settings/account', 'SettingsController@account');
Route::patch('settings/changeEmail', 'SettingsController@changeEmail');
Route::patch('settings/changePassword', 'SettingsController@changePassword');
Route::patch('settings/company', 'SettingsController@company');
Route::patch('settings/email', 'SettingsController@email');
Route::post('settings/subscribe', 'SettingsController@subscribe');
Route::post('settings/downgradeSubscription', 'SettingsController@downgradeSubscription');
Route::post('settings/upgradeSubscription', 'SettingsController@upgradeSubscription');
Route::patch('settings/permissions', 'SettingsController@permissions');

Route::get('datatables/todaysroute', 'DataTableController@todaysroute');
Route::get('datatables/reports', 'DataTableController@reports');
Route::get('datatables/workorders', 'DataTableController@workOrders');
Route::get('datatables/works/{workOrderSeqId}', 'DataTableController@works');
Route::get('datatables/missingServices', 'DataTableController@missingServices');
Route::get('datatables/missingServicesInfo', 'DataTableController@missingServicesInfo');
Route::get('datatables/services', 'DataTableController@services');
Route::get('datatables/equipment/{service_seq_id}', 'DataTableController@equipment');
Route::get('datatables/clients', 'DataTableController@clients');
Route::get('datatables/supervisors', 'DataTableController@supervisors');
Route::get('datatables/technicians', 'DataTableController@technicians');
