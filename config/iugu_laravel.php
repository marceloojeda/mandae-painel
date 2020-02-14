<?php

/*
|--------------------------------------------------------------------------
| File which returns array of constants containing IuguLaravel configs. 
|--------------------------------------------------------------------------
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Iugu API key
    |--------------------------------------------------------------------------
    |
    | Specify the key used to authenticate on Iugu API
    |
    */

    'production' => [
        'IUGU_API_KEY' => env('IUGU_API_KEY'),
        'IUGU_ACCOUNT_ID' => env('IUGU_ACCOUNT_ID'),
    ],

    'test' => [
        'IUGU_API_KEY' => env('IUGU_API_KEY_TEST'),
        'IUGU_ACCOUNT_ID' => env('IUGU_ACCOUNT_ID_TEST'),
    ],
];
