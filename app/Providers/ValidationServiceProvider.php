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
        /**
         * Validation condition to check for date order in database
         */
        Validator::extend('afterDB', function($attribute, $value, $parameters, $validator) {
            $table = $parameters[0];
            $column = $parameters[1];
            $id = $parameters[2];

            $beforeDateRaw = DB::table($table)
                ->select($column)
                ->where('id', $id)
                ->first()->$column;

            $beforeDate = (new Carbon($beforeDateRaw, 'UTC'));
            $afterDate = (new Carbon($value))->setTimezone('UTC');

            return $beforeDate->lt($afterDate);
        });
        // message generation for the condition
        Validator::replacer('afterDB', function($message, $attribute, $rule, $parameters) {
            $table = $parameters[0];
            $column = $parameters[1];
            $id = $parameters[2];

            $beforeDateRaw = DB::table($table)
                ->select($column)
                ->where('id', $id)
                ->first()->$column;

            return "The {$attribute} date should be after {$beforeDateRaw}";
        });

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
