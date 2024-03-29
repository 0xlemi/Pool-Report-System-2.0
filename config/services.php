<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Company::class,
        'key' => env('STRIPE_MAIN_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'client_id' => env('STRIPE_KEY'),
        'client_secret' => env('STRIPE_SECRET'),
        'redirect' => env('STRIPE_REDIRECT_URI')
    ],

    'sendbird' => [
        'App_Id' => env('SENDBIRD_ID'),
        'Api_Token' => env('SENDBIRD_TOKEN')
    ],

    'devicemagic' => [
        'token' => env('DEVICE_MAGIC_TOKEN'),
        'organization_id' => env('DEVICE_MAGIC_ORGANIZATION_ID')
    ]

];
