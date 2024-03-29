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

// Authentication
Route::group(['middleware' => ['throttle:10'] ], function (){
	// Route::post('activate/resend', 'Api\UserController@resendVerificationEmail');
});

Route::post('constants', 'Api\UserController@constants');

Route::group(['middleware' => ['auth:api', 'checkActive', 'checkVerified'] ], function(){


	// User
	Route::get('account', 'Api\UserController@show');
	Route::get('account/chat', 'Api\UserController@chat');
	Route::post('account', 'Api\UserController@update');
	Route::post('account/notifications', 'Api\UserController@notifications');

	// Todays Route
	Route::get('todaysroute', 'Api\TodaysRouteController@index');

	// Company
	Route::get('company', 'Api\CompanyController@show');
	Route::post('company', 'Api\CompanyController@update');
	Route::delete('company', 'Api\CompanyController@destroy');

	// Global Measurments
	Route::resource('globalmeasurements', 'Api\GlobalMeasurementController', ['except' => [
		'create', 'edit'
	]]);

	// Global Products
	Route::resource('globalproducts', 'Api\GlobalProductController', ['except' => [
		'create', 'edit'
	]]);

	// Permissions
	Route::get('permissions/list', 'Api\PermissionController@index');
	Route::get('permissions/all', 'Api\PermissionController@all');
	Route::post('permissions', 'Api\PermissionController@store');
	Route::get('permissions', 'Api\PermissionController@show');
	Route::delete('permissions', 'Api\PermissionController@destroy');

	// Reports
	Route::resource('reports', 'Api\ReportsController', ['except' => [
		'create', 'edit'
	]]);


	// Work Order
	Route::resource('workorders', 'Api\WorkOrderController', ['except' => [
		'create', 'edit'
	]]);
	Route::post('workorders/{seq_id}/finish', 'Api\WorkOrderController@finish');
		// Work
		Route::get('workorders/{workOrderSeqId}/work', 'Api\WorkController@index');
		Route::post('workorders/{workOrderSeqId}/work', 'Api\WorkController@store');
		Route::get('work/{work}', 'Api\WorkController@show');
		Route::post('work/{work}', 'Api\WorkController@update');
		Route::delete('work/{work}', 'Api\WorkController@destroy');


	// Service
	Route::resource('services', 'Api\ServicesController', ['except' => [
		'create', 'edit'
	]]);
		// Contract
		Route::get('services/{serviceSeqId}/contract', 'Api\ServiceContractsController@show');
		Route::post('services/{serviceSeqId}/contract', 'Api\ServiceContractsController@storeOrUpdate');
		Route::delete('services/{serviceSeqId}/contract', 'Api\ServiceContractsController@destroy');
		// Equipment
		Route::get('services/{serviceSeqId}/equipment', 'Api\EquipmentController@index');
		Route::post('services/{serviceSeqId}/equipment', 'Api\EquipmentController@store');
		Route::get('equipment/{equipment}', 'Api\EquipmentController@show');
		Route::post('equipment/{equipment}', 'Api\EquipmentController@update');
		Route::delete('equipment/{equipment}', 'Api\EquipmentController@destroy');
		// Products
		Route::get('services/{serviceSeqId}/products', 'Api\ProductController@index');
		Route::post('services/{serviceSeqId}/products', 'Api\ProductController@store');
		Route::get('products/{product}', 'Api\ProductController@show');
		Route::post('products/{product}', 'Api\ProductController@update');
		Route::delete('products/{product}', 'Api\ProductController@destroy');
		// Measurements
		Route::get('services/{serviceSeqId}/measurements', 'Api\MeasurementController@index');
		Route::post('services/{serviceSeqId}/measurements', 'Api\MeasurementController@store');
		Route::get('measurements/{measurement}', 'Api\MeasurementController@show');
		Route::post('measurements/{measurement}', 'Api\MeasurementController@update');
		Route::delete('measurements/{measurement}', 'Api\MeasurementController@destroy');


	//  UserRoleCompany
	Route::resource('userrolecompanies', 'Api\UserRoleCompanyController', ['except' => [
		'create', 'edit'
	]]);


	// Invoces
	Route::resource('invoices', 'Api\InvoiceController', ['only' => [
	    'index', 'show', 'destroy'
	]]);
		// Payments
		Route::resource('payments', 'Api\PaymentController', ['only' => [
		    'show', 'destroy'
		]]);
		Route::get('invoices/{invoiceSeqId}/payments', 'Api\PaymentController@index');
		Route::post('invoices/{invoiceSeqId}/payments', 'Api\PaymentController@store');


});
