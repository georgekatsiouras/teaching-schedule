<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'wonde' => [
        'token' => env('WONDE_TOKEN', '4bcdffb1b5ff4e758665c2802590834fd4caba70'),
        'base_api_url' => env('BASE_API_URL', 'https://api.wonde.com/v1.0'),
        'schools_prefix' => env('SCHOOLS_PREFIX', '/schools'),
        'testing_school_id' => env('TESTING_SCHOOL_ID', 'A1930499544'),
        'employees_endpoint' => env('EMPLOYEES_ENDPOINT', '/employees'),
        'classes_endpoint' => env('CLASSES_ENDPOINT', '/classes'),
        'lessons_endpoint' => env('LESSONS_ENDPOINT', '/lessons'),
    ]

];
