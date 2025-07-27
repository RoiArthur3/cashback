<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Exception Handling
    |--------------------------------------------------------------------------
    |
    | This file allows you to configure the behavior of the exception handler.
    | You can specify which exceptions should be reported and which should be
    | ignored, as well as custom rendering logic for specific exceptions.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Error Logging
    |--------------------------------------------------------------------------
    |
    | Here you may configure the error logging preferences for your application.
    |
    */
    'log' => env('LOG_EXCEPTIONS', true),

    /*
    |--------------------------------------------------------------------------
    | Ignored Exceptions
    |--------------------------------------------------------------------------
    |
    | Here you may specify the list of exceptions that should not be reported.
    |
    */
    'ignore' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Error Pages
    |--------------------------------------------------------------------------
    |
    | Here you may specify the custom error pages for different HTTP status
    | codes. These pages will be displayed when an error of the corresponding
    | status code occurs.
    |
    */
    'pages' => [
        403 => 'errors.403',
        404 => 'errors.404',
        419 => 'errors.419',
        429 => 'errors.429',
        500 => 'errors.500',
        503 => 'errors.503',
    ],
];
