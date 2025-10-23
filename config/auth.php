<?php

return [

    'defaults' => [
        'guard' => 'web',          // الافتراضي للمستخدمين العاديين
        'passwords' => 'users',
    ],

    'guards' => [
        // 🌍 المستخدم العادي
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // 🔑 API للمستخدمين (Sanctum)
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],

        // 👨‍✈️ السائقين (دخول مستقل)
        'driver' => [
            'driver' => 'session',
            'provider' => 'drivers',
        ],

        // 🚖 API للسائقين
        'driver_api' => [
            'driver' => 'sanctum',
            'provider' => 'drivers',
        ],
    ],

    'providers' => [
        // 🌍 المستخدمين
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 👨‍✈️ السائقين
        'drivers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Driver::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // 👨‍✈️ استرجاع كلمة مرور السائقين
        'drivers' => [
            'provider' => 'drivers',
            'table' => 'driver_password_resets', // نعملها Migration لو بدنا
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
