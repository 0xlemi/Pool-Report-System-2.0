<?php
use Illuminate\Http\Request;

dd(config('constants.timezones'));

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

// Welcome Page
Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/logout', 'Auth\LoginController@logout');

// Activation
Route::get('activate/token/{token}', 'Auth\ActivationController@activate')->name('auth.activate');
Route::get('activate/resend', 'Auth\ActivationController@resend')->name('auth.activate.resend');

// change email settings from link
Route::group(['middleware' => ['throttle:500'] ], function (){
    Route::get('/unsubscribe/{token}', 'HomeController@emailOptions');
    Route::post('/unsubscribe', 'HomeController@changeEmailOptions');
});

// Todays Route
Route::get('todaysroute', 'TodaysRouteController@index');
Route::get('todaysroute/report/{service_seq_id}', 'TodaysRouteController@createReport');
Route::post('todaysroute/report', 'TodaysRouteController@storeReport');

// Reports
Route::get('reports/emailPreview', 'ReportsController@emailPreview');
Route::get('reports/photos/{seq_id}', 'ReportsController@getPhoto');
Route::post('reports/photos/{seq_id}', 'ReportsController@addPhoto');
Route::delete('reports/photos/{seq_id}/{order}', 'ReportsController@removePhoto');

// Work Orders
Route::post('workorders/finish/{seq_id}', 'WorkOrderController@finish');
Route::get('workorders/photos/before/{seq_id}', 'WorkOrderController@getPhotosBefore');
Route::get('workorders/photos/after/{seq_id}', 'WorkOrderController@getPhotosAfter');
Route::post('workorders/photos/before/{seq_id}', 'WorkOrderController@addPhotoBefore');
Route::post('workorders/photos/after/{seq_id}', 'WorkOrderController@addPhotoAfter');
Route::delete('workorders/photos/before/{seq_id}/{order}', 'WorkOrderController@removePhotoBefore');
Route::delete('workorders/photos/after/{seq_id}/{order}', 'WorkOrderController@removePhotoAfter');

// Works
Route::get('service/{workOrderSeqId}/works', 'WorkController@index');
Route::post('service/{workOrderSeqId}/works', 'WorkController@store');
Route::post('works/photos/{work}', 'WorkController@addPhoto');
Route::delete('works/photos/{work}/{order}', 'WorkController@removePhoto');

// Equipment
Route::get('service/{service_seq_id}/equipment', 'EquipmentController@index');
Route::post('service/{workOrderSeqId}/equipment', 'EquipmentController@store');
Route::post('equipment/photos/{equipment}', 'EquipmentController@addPhoto');
Route::delete('equipment/photos/{equipment}/{order}', 'EquipmentController@removePhoto');

// Chemicals
Route::get('chemicals/{serviceSeqId}', 'chemicalController@index');
Route::post('chemicals/{serviceSeqId}', 'chemicalController@store');

// Service Contracts
Route::get('servicecontracts/{serviceSeqId}', 'ServiceContractsController@show');
Route::post('servicecontracts/{serviceSeqId}', 'ServiceContractsController@store');
Route::patch('servicecontracts/{serviceSeqId}', 'ServiceContractsController@update');
Route::post('servicecontracts/{serviceSeqId}/active', 'ServiceContractsController@toggleActivation');
Route::delete('servicecontracts/{serviceSeqId}', 'ServiceContractsController@destroy');

// Missing Services
Route::get('missingservices', 'MissingServicesController@index');

// Payments
Route::get('invoices/{invoiceSeqId}/payments', 'PaymentController@index');
Route::post('invoices/{invoiceSeqId}/payments', 'PaymentController@store');

// Notifications
Route::get('notifications', 'NotificationController@index');
Route::get('notifications/widget', 'NotificationController@widget');
Route::post('notifications/read/widget', 'NotificationController@markWidgetAsRead');
Route::post('notifications/read/all', 'NotificationController@markAllAsRead');

Route::resource('reports', 'ReportsController');
Route::resource('workorders', 'WorkOrderController');
Route::resource('works', 'WorkController', ['only' => [
    'show', 'update', 'destroy'
]]);
Route::resource('services', 'ServicesController');
Route::resource('equipment', 'EquipmentController', ['only' => [
    'show', 'update', 'destroy'
]]);
Route::resource('chemicals', 'chemicalController', ['only' => [
    'update', 'destroy'
]]);
Route::resource('clients', 'ClientsController');
Route::resource('supervisors', 'SupervisorsController');
Route::resource('technicians', 'TechniciansController');
Route::resource('invoices', 'InvoiceController', ['only' => [
    'index', 'show', 'destroy'
]]);
Route::resource('payments', 'PaymentController', ['only' => [
    'show', 'destroy'
]]);
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
Route::get('datatables/services', 'DataTableController@services');
Route::get('datatables/clients', 'DataTableController@clients');
Route::get('datatables/supervisors', 'DataTableController@supervisors');
Route::get('datatables/technicians', 'DataTableController@technicians');
Route::get('datatables/invoices', 'DataTableController@invoices');
