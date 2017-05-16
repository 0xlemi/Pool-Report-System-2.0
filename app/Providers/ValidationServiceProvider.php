<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Validation condition to check if checkReportCanAcceptReading are vaild
        Validator::extend('checkReportCanRemoveReadingFromServiceId', 'App\PRS\Validators\CheckReportCanRemoveReadingFromServiceId@validate');
        Validator::replacer('checkReportCanRemoveReadingFromServiceId', 'App\PRS\Validators\CheckReportCanRemoveReadingFromServiceId@message');

        // Validation condition to check if checkReportCanAcceptReading are vaild
        Validator::extend('checkReportCanAcceptReadingFromServiceId', 'App\PRS\Validators\CheckReportCanAcceptReadingFromServiceId@validate');
        Validator::replacer('checkReportCanAcceptReadingFromServiceId', 'App\PRS\Validators\CheckReportCanAcceptReadingFromServiceId@message');

        // Validation condition to check if meassurment has the selected value lable are vaild
        Validator::extend('validMeasurementValue', 'App\PRS\Validators\ValidMeasurementValue@validate');
        Validator::replacer('validMeasurementValue', 'App\PRS\Validators\ValidMeasurementValue@message');

        // Validation condition to check if checkReportCanAcceptReading are vaild
        Validator::extend('checkReportCanAcceptReading', 'App\PRS\Validators\CheckReportCanAcceptReading@validate');
        Validator::replacer('checkReportCanAcceptReading', 'App\PRS\Validators\CheckReportCanAcceptReading@message');

        // Validation condition to check if report readings are vaild
        Validator::extend('validPermissionElement', 'App\PRS\Validators\ValidPermissionElement@validate');
        Validator::replacer('validPermissionElement', 'App\PRS\Validators\ValidPermissionElement@message');

        // Validation condition to check if report readings are vaild
        Validator::extend('validPermissionAction', 'App\PRS\Validators\ValidPermissionAction@validate');
        Validator::replacer('validPermissionAction', 'App\PRS\Validators\ValidPermissionAction@message');

        // Validation condition to check if report readings are vaild
        Validator::extend('validReading', 'App\PRS\Validators\ValidReading@validate');
        Validator::replacer('validReading', 'App\PRS\Validators\ValidReading@message');

        // Validation condition to check if object exists in the admin system based on seq_id and administartor
        Validator::extend('validConstant', 'App\PRS\Validators\ValidConstant@validate');
        Validator::replacer('validConstant', 'App\PRS\Validators\ValidConstant@message');

        // Validation condition to check if object exists in the admin system based on seq_id and administartor
        Validator::extend('existsBasedOnCompany', 'App\PRS\Validators\ExistsBasedOnCompany@validate');
        Validator::replacer('existsBasedOnCompany', 'App\PRS\Validators\ExistsBasedOnCompany@message');

        // Validation condition to check if date for serching reports vaild
        Validator::extend('validDateReportFormat', 'App\PRS\Validators\ValidDateReportFormat@validate');
        Validator::replacer('validDateReportFormat', 'App\PRS\Validators\ValidDateReportFormat@message');

        // Validation condition to check if notification type is vaild
        Validator::extend('validNotificationType', 'App\PRS\Validators\ValidNotificationType@validate');
        Validator::replacer('validNotificationType', 'App\PRS\Validators\ValidNotificationType@message');

        // Validation condition to check if notification is vaild
        Validator::extend('validNotification', 'App\PRS\Validators\ValidNotification@validate');
        Validator::replacer('validNotification', 'App\PRS\Validators\ValidNotification@message');

        // Validation condition to check if permission is vaild
        Validator::extend('validPermission', 'App\PRS\Validators\ValidPermission@validate');
        Validator::replacer('validPermission', 'App\PRS\Validators\ValidPermission@message');

        // Validation condition to check if permission is vaild
        Validator::extend('validRole', 'App\PRS\Validators\ValidRole@validate');
        Validator::replacer('validRole', 'App\PRS\Validators\ValidRole@message');

        // Validation condition to language is supported
        Validator::extend('validLanguage', 'App\PRS\Validators\ValidLanguage@validate');
        Validator::replacer('validLanguage', 'App\PRS\Validators\ValidLanguage@message');

        // Validation condition to timezone is supported
        Validator::extend('validTimezone', 'App\PRS\Validators\ValidTimezone@validate');
        Validator::replacer('validTimezone', 'App\PRS\Validators\ValidTimezone@message');

        // Validation condition to currency is supported
        Validator::extend('validCurrency', 'App\PRS\Validators\ValidCurrency@validate');
        Validator::replacer('validCurrency', 'App\PRS\Validators\ValidCurrency@message');

        // Validation condition to check for date order in database
        Validator::extend('afterDB', 'App\PRS\Validators\DateTimeAfterDB@validate');
        Validator::replacer('afterDB', 'App\PRS\Validators\DateTimeAfterDB@message');

        // Validation condition to check for date order in database
        Validator::extend('timeAfterDB', 'App\PRS\Validators\TimeAfterDB@validate');
        Validator::replacer('timeAfterDB', 'App\PRS\Validators\TimeAfterDB@message');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
