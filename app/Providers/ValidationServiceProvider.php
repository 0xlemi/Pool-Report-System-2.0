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
        // Validation condition to currency is supported
        Validator::extend('validCurrency', 'App\PRS\Validators\ValidCurrency@validate');
        Validator::replacer('validCurrency', 'App\PRS\Validators\ValidCurrency@message');

        // Validation condition to check for date order in database
        Validator::extend('afterDB', 'App\PRS\Validators\TimeAfterDB@validate');
        Validator::replacer('afterDB', 'App\PRS\Validators\TimeAfterDB@message');

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
