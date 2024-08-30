<?php

/*
|--------------------------------------------------------------------------
| APIs
|--------------------------------------------------------------------------
|
|
*/

return [
    'mercado_pago' => [
        'access_token' => env('MERCADO_PAGO_ACCESS_TOKEN'),
        'token_notification' => env('MERCADO_PAGO_TOKEN_NOTIFICATION')
    ],
    'stripe' => [
        'api_key' => env('STRIPE_KEY'),
        'token_notification' => env('STRIPE_TOKEN_NOTIFICATION')
    ]
];


