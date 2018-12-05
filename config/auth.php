<?php

return [
 
    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

   'defaults' => [
        'guard' => 'web',
        'passwords' => 't_employee',
    ],


    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
       'web' => [
            'driver' => 'session',
            'provider' => 't_employee',
        ],
        'api' => [
            'driver' => 'passport',
            'provider' => 't_employee',
        ],
        't_student' => [
            'driver' => 'session',
            'provider' => 't_student',
        ],
        'tparent' => [
            'driver' => 'session',
            'provider' => 'tparent',
        ],
          'token' => [
            'driver'   => 'access_token',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
't_employee' => [
            'driver' => 'eloquent',
            'model' => App\Employee::class,
        ],
't_student' => [
            'driver' => 'eloquent',
            'model' => App\BaseModels\Student::class,
        ],
'tparent' => [
            'driver' => 'eloquent',
            'model' => App\Tparent::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
 't_employee' => [
            'provider' => 't_employee',
            'table' => 'password_resets',
            'expire' => 60,
        ],
 't_student' => [
            'provider' => 't_student',
            'table' => 'password_resets',
            'expire' => 60,
        ],
 'tparent' => [
            'provider' => 'tparent',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
