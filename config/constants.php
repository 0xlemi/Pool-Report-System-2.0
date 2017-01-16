<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Constants for Pool Report System
    |--------------------------------------------------------------------------
    */

    'currencies' => [
        'USD',
        'MXN',
        'CAD',
        'EUR',
    ],

    'languages' => [
        'en',
        'es'
    ],

    'timezones' =>  DateTimeZone::listIdentifiers(DateTimeZone::ALL),

    'startLocation' => [
        'latitude' => '23.0446032',
        'longitude' => '-109.705866',
    ]

];
