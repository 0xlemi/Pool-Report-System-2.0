<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force Http in heroku
        if(env('APP_ENV') == 'production'){
            URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
