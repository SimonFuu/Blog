<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
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
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'weibo' => [
        'client_id' => '2785719256',
        'client_secret' => '29784adcb76395378ff8670c165a2688',
        'redirect' => 'http://www.fushupeng.com'
    ],

    'github' => [
        'client_id' => 'ac2fd40636dbb5f53d0e',
        'client_secret' => 'a60bcedd5f3576f000338f8e750a26c9a8d6a403',
        'redirect' => 'http://www.fushupeng.dev/oauth/github/callback'
    ]
];
