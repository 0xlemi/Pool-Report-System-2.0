<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Constants for Pool Report System
    |--------------------------------------------------------------------------
    */

    'constants' => [
        'currencies',
        'languages',
        'timezones',
    ],

    'currencies' => [
        'USD',
        'MXN',
        'CAD',
        'EUR',
        'GBP',
        'BRL',
        'AUD',
    ],

    'paymentMethods' => [
        'cash',
        'transfer',
        'check',
        'credit_card',
        'debit',
        'atm_withdrawals'
    ],

    'languages' => [
        'en',
        'es'
    ],

    'timezones' =>  DateTimeZone::listIdentifiers(DateTimeZone::ALL),

];
