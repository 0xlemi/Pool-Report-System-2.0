<?php
use Illuminate\Http\Request;
use App\Role;

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

// Stripe
    // Connect
    Route::get('/connect/login', 'Stripe\ConnectController@redirectToProvider');
    Route::get('/connect/login/callback', 'Stripe\ConnectController@handleProviderCallback');
    Route::post('/connect/remove', 'Stripe\ConnectController@removeAccount');
    Route::post('/connect/customer', 'Stripe\ConnectController@createCustomer');
    Route::delete('/connect/customer', 'Stripe\ConnectController@removeCustomer');
    // Subscription
    Route::post('settings/subscribe', 'Stripe\SubscriptionController@subscribe');
    Route::post('settings/downgradeSubscription', 'Stripe\SubscriptionController@downgradeSubscription');
    Route::post('settings/upgradeSubscription', 'Stripe\SubscriptionController@upgradeSubscription');

// magic link login
Route::get('/signin/{token}', 'HomeController@signIn');

Route::get('/dashboard', 'HomeController@dashboard')->middleware('auth');
Route::get('/home', 'HomeController@home')->middleware('auth');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/change/role/{id}', 'UserRoleCompanyController@change');

// Verification
Route::get('activate/token/{token}', 'Auth\VerificationController@activate')->name('auth.activate');
Route::post('activate/password', 'Auth\VerificationController@setPassword');
Route::get('activate/resend', 'Auth\VerificationController@resend')->name('auth.activate.resend');

// change email settings from link
Route::group(['middleware' => ['throttle:500'] ], function (){
    Route::get('/unsubscribe/{token}', 'HomeController@emailOptions');
    Route::post('/unsubscribe', 'HomeController@changeEmailOptions');
});

// Device Magic Mobile App
Route::post('devicemagic/report', 'Mobile\DeviceMagicController@report');
Route::post('devicemagic/workorder', 'Mobile\DeviceMagicController@workorder');

// Query
Route::get('/query/servicesworkorderinvoices', 'QueryController@servicesWorkOrderMonthlyBalance');
Route::get('/query/servicescontractinvoices', 'QueryController@servicesContractMonthlyBalance');
Route::get('/query/servicescontractinvoices/pdf', 'QueryController@servicesContractMonthlyBalancePDF');
Route::get('/query/servicescontractinvoices/excel', 'QueryController@servicesContractMonthlyBalanceExcel');

// Documentation
Route::get('/docs', 'DocumentationController@index');
Route::get('/docs/quick', 'DocumentationController@quick');
Route::get('/docs/user', 'DocumentationController@user');
Route::get('/docs/company', 'DocumentationController@company');
Route::get('/docs/service', 'DocumentationController@service');
Route::get('/docs/report', 'DocumentationController@report');
Route::get('/docs/todaysroute', 'DocumentationController@todaysroute');
Route::get('/docs/workorder', 'DocumentationController@workorder');
Route::get('/docs/invoice', 'DocumentationController@invoice');
Route::get('/docs/chat', 'DocumentationController@chat');
Route::get('/docs/setting', 'DocumentationController@setting');

// Client Interface
Route::get('report', 'ClientInterfaceController@reports');
Route::post('report', 'ClientInterfaceController@reportsByDate');
Route::get('workorder', 'ClientInterfaceController@workOrders');
Route::get('workorder/table', 'ClientInterfaceController@workOrderTable');
Route::get('workorder/{workorder}', 'ClientInterfaceController@workOrderShow');
Route::get('service', 'ClientInterfaceController@services');
Route::get('service/table', 'ClientInterfaceController@serviceTable');
Route::get('service/{service}', 'ClientInterfaceController@serviceShow');
Route::get('invoice', 'ClientInterfaceController@invoices');
Route::get('invoice/table', 'ClientInterfaceController@invoiceTable');
Route::get('invoice/{inovice}', 'ClientInterfaceController@invoiceShow');

// Todays Route
Route::get('todaysroute', 'TodaysRouteController@index');
Route::get('todaysroute/report/{service_seq_id}', 'TodaysRouteController@createReport');
Route::post('todaysroute/report', 'TodaysRouteController@storeReport');

// Reports
Route::get('reports/emailPreview', 'ReportsController@emailPreview');
Route::get('reports/photos/{seq_id}', 'ReportsController@getPhoto');
Route::post('reports/photos/{seq_id}', 'ReportsController@addPhoto');
Route::delete('reports/photos/{seq_id}/{order}', 'ReportsController@removePhoto');
Route::post('reports/readings', 'ReportsController@createAddReadings');
Route::resource('reports', 'ReportsController');

// Technician
Route::post('technicians/password/{seq_id}', 'TechniciansController@updatePassword');
Route::resource('technicians', 'TechniciansController');

// Work Orders
Route::post('workorders/finish/{seq_id}', 'WorkOrderController@finish');
Route::get('workorders/photos/before/{seq_id}', 'WorkOrderController@getPhotosBefore');
Route::get('workorders/photos/after/{seq_id}', 'WorkOrderController@getPhotosAfter');
Route::post('workorders/photos/before/{seq_id}', 'WorkOrderController@addPhotoBefore');
Route::post('workorders/photos/after/{seq_id}', 'WorkOrderController@addPhotoAfter');
Route::delete('workorders/photos/before/{seq_id}/{order}', 'WorkOrderController@removePhotoBefore');
Route::delete('workorders/photos/after/{seq_id}/{order}', 'WorkOrderController@removePhotoAfter');
Route::resource('workorders', 'WorkOrderController');

// Works
Route::get('service/{workOrderSeqId}/works', 'WorkController@index');
Route::post('service/{workOrderSeqId}/works', 'WorkController@store');
Route::post('works/photos/{work}', 'WorkController@addPhoto');
Route::delete('works/photos/{work}/{order}', 'WorkController@removePhoto');
Route::resource('works', 'WorkController', ['only' => [
    'show', 'update', 'destroy'
]]);

// Global Product
Route::post('globalproducts/photos/{globalProduct}', 'GlobalProductController@addPhoto');
Route::delete('globalproducts/photos/{globalProduct}/{order}', 'GlobalProductController@removePhoto');
Route::resource('globalproducts', 'GlobalProductController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
]]);

// Equipment
Route::get('service/{service_seq_id}/equipment', 'EquipmentController@index');
Route::post('service/{workOrderSeqId}/equipment', 'EquipmentController@store');
Route::post('equipment/photos/{equipment}', 'EquipmentController@addPhoto');
Route::delete('equipment/photos/{equipment}/{order}', 'EquipmentController@removePhoto');
Route::resource('equipment', 'EquipmentController', ['only' => [
    'show', 'update', 'destroy'
]]);

// Measurements
Route::get('service/{serviceSeqId}/measurements', 'MeasurementsController@index');
Route::post('service/{serviceSeqId}/measurements', 'MeasurementsController@store');
Route::resource('measurements', 'MeasurementsController', ['only' => [
    'show', 'destroy'
]]);

// Prouducts
Route::get('service/{serviceSeqId}/products', 'ProductController@index');
Route::post('service/{serviceSeqId}/products', 'ProductController@store');
Route::resource('products', 'ProductController', ['only' => [
    'show', 'update', 'destroy'
]]);

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
Route::resource('payments', 'PaymentController', ['only' => [
    'show', 'destroy'
]]);

// Notifications
Route::get('notifications', 'NotificationController@index');
Route::get('notifications/widget', 'NotificationController@widget');
Route::post('notifications/read/widget', 'NotificationController@markWidgetAsRead');
Route::post('notifications/read/all', 'NotificationController@markAllAsRead');


Route::resource('services', 'ServicesController');
Route::resource('clients', 'ClientsController');
Route::resource('supervisors', 'SupervisorsController');
Route::resource('invoices', 'InvoiceController', ['only' => [
    'index', 'show', 'destroy'
]]);

// Chat
Route::get('chat', 'ChatController@home');
Route::get('chat/id/{seqId}', 'ChatController@userChatId');
Route::get('chat/unreadcount/{seqId}', 'ChatController@unreadCount');

// Stripe
Route::post(
    'stripe/webhook',
    'Stripe\WebhookController@handleWebhook'
);

// Settings
Route::get('settings', 'SettingsController@index');
Route::get('developer', 'SettingsController@developer');
// profile
Route::post('settings/profile', 'SettingsController@profile');
Route::post('settings/changeEmail', 'SettingsController@changeEmail');
Route::post('settings/changePassword', 'SettingsController@changePassword');
Route::delete('settings/delete', 'SettingsController@deleteAccount');
// customization
Route::post('settings/customization', 'SettingsController@customization');
// notifications
Route::post('settings/notifications', 'SettingsController@notifications');
// permissions
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
