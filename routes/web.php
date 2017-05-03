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

// Welcome Page
Route::get('/', 'HomeController@landingPage');
Route::get('/terms', 'HomeController@terms');
Route::get('/features', 'HomeController@features');
Route::get('/pricing', 'HomeController@pricing');
Route::get('/tutorials', 'HomeController@tutorials');
Route::get('/support', 'HomeController@support');

// magic link login
Route::get('/signin/{token}', 'HomeController@signIn');

Route::get('/dashboard', 'HomeController@dashboard')->middleware('auth');
Route::get('/home', 'HomeController@home')->middleware('auth');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/change/role/{id}', 'UserRoleCompanyController@change');

// Verification
Route::get('activate/token/{token}', 'Auth\VerificationController@activate')->name('auth.activate');
Route::post('activate/password', 'Auth\VerificationController@setPassword');
// Route::get('activate/resend', 'Auth\VerificationController@resend')->name('auth.activate.resend');

// change email settings from link
Route::group(['middleware' => ['throttle:500'] ], function (){
    Route::get('/unsubscribe/{token}', 'HomeController@emailOptions');
    Route::post('/unsubscribe', 'HomeController@changeEmailOptions');
});

// Client Interface
Route::get('report', 'ClientInterfaceController@reports');
Route::post('report', 'ClientInterfaceController@reportsByDate');
Route::get('workorder', 'ClientInterfaceController@workOrders');
Route::get('workorder/table', 'ClientInterfaceController@workOrderTable');
Route::get('workorder/{workorder}', 'ClientInterfaceController@workOrderShow');
Route::get('service', 'ClientInterfaceController@services');
Route::get('service/table', 'ClientInterfaceController@serviceTable');
Route::get('service/{service}', 'ClientInterfaceController@serviceShow');
Route::get('statement', 'ClientInterfaceController@statement');

// Todays Route
Route::get('todaysroute', 'TodaysRouteController@index');
Route::get('todaysroute/report/{service_seq_id}', 'TodaysRouteController@createReport');
Route::post('todaysroute/report', 'TodaysRouteController@storeReport');

// Reports
Route::get('reports/emailPreview', 'ReportsController@emailPreview');
Route::get('reports/photos/{seq_id}', 'ReportsController@getPhoto');
Route::post('reports/photos/{seq_id}', 'ReportsController@addPhoto');
Route::delete('reports/photos/{seq_id}/{order}', 'ReportsController@removePhoto');

// Technician
Route::post('technicians/password/{seq_id}', 'TechniciansController@updatePassword');

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

// Measurements
Route::get('measurements/{serviceSeqId}', 'MeasurementsController@index');
Route::post('measurements/{serviceSeqId}', 'MeasurementsController@store');

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

// Reports
Route::resource('reports', 'ReportsController');
Route::post('reports/readings', 'ReportsController@createAddReadings');

Route::resource('workorders', 'WorkOrderController');
Route::resource('works', 'WorkController', ['only' => [
    'show', 'update', 'destroy'
]]);
Route::resource('services', 'ServicesController');
Route::resource('equipment', 'EquipmentController', ['only' => [
    'show', 'update', 'destroy'
]]);
Route::resource('measurements', 'measurementController', ['only' => [
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

// Chat
Route::get('chat', 'ChatController@home');
Route::get('chat/id/{seqId}', 'ChatController@userChatId');
Route::get('chat/unreadcount/{seqId}', 'ChatController@unreadCount');


Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);

// Settings
Route::get('settings', 'SettingsController@index');

Route::post('settings/profile', 'SettingsController@profile');
Route::post('settings/changeEmail', 'SettingsController@changeEmail');
Route::post('settings/changePassword', 'SettingsController@changePassword');
Route::delete('settings/delete', 'SettingsController@deleteAccount');

Route::post('settings/customization', 'SettingsController@customization');

Route::post('settings/notifications', 'SettingsController@notifications');

Route::post('settings/subscribe', 'SettingsController@subscribe');
Route::post('settings/downgradeSubscription', 'SettingsController@downgradeSubscription');
Route::post('settings/upgradeSubscription', 'SettingsController@upgradeSubscription');

Route::post('settings/permissions', 'SettingsController@permissions');

// Datatables
Route::get('datatables/todaysroute', 'DataTableController@todaysroute');
Route::get('datatables/reports', 'DataTableController@reports');
Route::get('datatables/workorders', 'DataTableController@workOrders');
Route::get('datatables/works/{workOrderSeqId}', 'DataTableController@works');
Route::get('datatables/services', 'DataTableController@services');
Route::get('datatables/urc', 'DataTableController@userRoleCompanies');
Route::get('datatables/clients', 'DataTableController@clients');
Route::get('datatables/supervisors', 'DataTableController@supervisors');
Route::get('datatables/technicians', 'DataTableController@technicians');
Route::get('datatables/invoices', 'DataTableController@invoices');
