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
        // Validation condition to check if object exists in the admin system based on seq_id and administartor
        Validator::extend('existsBasedOnAdmin', 'App\PRS\Validators\ExistsBasedOnAdmin@validate');
        Validator::replacer('existsBasedOnAdmin', 'App\PRS\Validators\ExistsBasedOnAdmin@message');

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
